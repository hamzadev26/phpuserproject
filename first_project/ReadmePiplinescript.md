pipeline {
agent any

    stages {

        stage('Code') {
            steps {
                git url: "https://github.com/hamzadev26/phpuserproject.git", branch: "main"
            }
        }

        stage('Build & Push') {
            steps {
                withCredentials([usernamePassword(
                    credentialsId: "DockerHubCredIDName",
                    usernameVariable: "DOCKER_USER",
                    passwordVariable: "DOCKER_PASS"
                )]) {
                    sh """
                    echo \$DOCKER_PASS | docker login -u \$DOCKER_USER --password-stdin
                    docker build -t \$DOCKER_USER/phpuserproject-web:v1 .
                    docker push \$DOCKER_USER/phpuserproject-web:v1
                    docker logout
                    """
                }
            }
        }

        stage('Deploy') {
            steps {
                withCredentials([
                    file(credentialsId: 'phpuserproject_env_file', variable: 'ENV_FILE')
                ]) {
                    sh """
                    echo "Stopping old containers..."
                    docker compose down || true

                    echo "Injecting .env file..."
                    cp \$ENV_FILE .env

                    echo "Starting containers..."
                    docker compose up -d --build

                    echo "Running containers:"
                    docker compose ps
                    """
                }
            }
        }

        stage('Verify') {
            steps {
                sh "docker compose logs --tail=50"
            }
        }
    }

    post {
        failure {
            echo "Pipeline failed!"
            sh "docker compose logs"
        }

        success {
            echo "Deployment successful!"
            sh "echo 'App: http://localhost:8081'"
        }

        always {
            echo "Pipeline finished."
        }
    }

}
