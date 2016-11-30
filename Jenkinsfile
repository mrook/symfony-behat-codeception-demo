node {
    checkout scm

    sh('git rev-parse HEAD > /tmp/GIT_COMMIT')
    git_commit=readFile('/tmp/GIT_COMMIT').trim()

    stage('Build docker image for test') {
        sh "docker build -t demoapp-test:$git_commit -f Dockerfile.test ."
    }

    parallel(
        syntax: {
            stage('Syntax check') {
                sh "docker run --rm --name demoapp-syntax demoapp-test:$git_commit bash -c \"find . -name '*.php' -not -path './vendor/*' -not -path './var/*' | xargs -I '{}' php -l {}\""
            }
        },
        unit: {
            stage('Unit tests') {
                sh "docker run --rm --name demoapp-unit demoapp-test:$git_commit vendor/bin/phpunit"
            }
        },
        acceptance: {
            stage('Acceptance tests') {
                sh "docker run --rm --name demoapp-behat demoapp-test:$git_commit vendor/bin/behat"
            }
        }
    )

    stage('Build docker image') {
        sh "docker build -t demoapp:$git_commit -f Dockerfile ."
    }

    stage('Deploy acceptance') {
        sh "docker rm -f demoapp-acc || true"
        sh "docker run -d --name demoapp-acc -p 7000:8080 demoapp:$git_commit"
    }

    stage('Deploy production') {
        sh "docker rm -f demoapp-prod || true"
        sh "docker run -d --name demoapp-prod -p 8000:8080 demoapp:$git_commit"
    }
}
