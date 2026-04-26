pipeline {
agent any

    environment {
        // Environment variables define kare hai github par .env file upload nahi karte
        DB_HOST = "db"
        DB_USER = "dev"
        DB_PASS = "123456"
        DB_NAME = "first_project"
        MYSQL_ROOT_PASSWORD = "rootpass"
        MYSQL_DATABASE = "first_project"
        MYSQL_USER = "dev"
        MYSQL_PASSWORD = "123456"
    }

    stages {
        stage('Code') {
            steps {
                echo 'Code clone kar raha hoon...'
                git url: "https://github.com/hamzadev26/phpuserproject.git", branch:"main"
            }
        }

        stage('Build And Run') {
            steps {
                echo 'Containers build aur start kar raha hoon...'
                sh "docker compose up -d --build"
                sh "sleep 10"  // Database ready hone ke liye wait kar
            }
        }

        stage('Verify') {
            steps {
                echo 'Services check kar raha hoon...'
                sh "docker compose ps"
                sh "docker compose logs"
            }
        }

        stage('Deploy') {
            steps {
                echo 'All containers successfully running! ✓'
                sh "echo 'Web: http://localhost:8080'"
                sh "echo 'Database: localhost:3307'"
            }
        }
    }

    post {
        failure {
            echo 'Pipeline fail ho gaya!'
            sh "docker compose logs"
        }
        always {
            echo 'Pipeline complete!'
        }
    }

}
