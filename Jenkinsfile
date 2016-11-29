node {
    checkout scm

    sh('git rev-parse HEAD > /tmp/GIT_COMMIT')
    git_commit=readFile('/tmp/GIT_COMMIT').trim()

    stage('Composer') {
        sh "composer install -o"
    }

    parallel {
        stage('Syntax check') {
            sh "find . -name '*.php' -not -path './vendor/*' -not -path './var/*' | xargs -I '{}' php -l {}"
        }
        stage('Unit tests') {
            sh "vendor/bin/phpunit"
        } 
        stage('Acceptance tests') {
            sh "vendor/bin/behat"
        }
    }

    stage('Build docker image') {
    }

    stage('Deploy acceptance') {
    }

    stage('Deploy production') {
    }
}
