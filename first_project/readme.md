Github Repo Se Code Clone Kiya
Docker Compose Se Image Build or Container Run Kiya

pushtodockerhub file . md

1.  Code Clone
2.  Build Image using Dockerfile
3.  Push to Docker Hub (v1 tag)
4.  Run Containers
5.  Verify
6.  Deploy

        stage('Build Image using Dockerfile') {
            steps {
                echo 'Image Build kar raha hoon...'
                sh "docker build -t phpuserproject-web:latest ."
            }
        }

        stage('Image Push to Docker Hub') {
            steps {
                echo 'Image Docker Hub Per Push Kar raha hoon...'
                withCredentials([usernamePassword(
                    'credentialsId': "DockerHubCredIDName",
                    passwordVariable:"dockerHubPass",
                    usernameVariable:"dockerHubUser")]){
                sh "docker login -u ${env.dockerHubUser} -p ${env.dockerHubPass}"
                sh "docker image tag phpuserproject-web:latest ${env.dockerHubUser}/phpuserproject-web:v1"
                sh "docker push ${env.dockerHubUser}/phpuserproject-web:v1"
                sh "docker logout"
                }
            }
        }

abhi mene jenkis ke script me direct add kar diya hai enviroment variable

Bilkul OK hai! ✅ Par kuch SECURITY CONCERNS hain:

Tera Approach (Direct Hardcode):

environment {
DB_PASS = "password123"
MYSQL_ROOT_PASSWORD = "root123"
}

Problems:

❌ Pipeline code mein passwords visible hote hain
❌ GitHub par password expose ho sakta hai
❌ Jenkins UI mein sab ko password dikhega
❌ Production vs Local ke liye alag passwords chahiye

BETTER Approach - Jenkins Credentials Use Kar:

1. Jenkins mein Secret Store Kar:

Jenkins → Manage Credentials
Add "Secret text" credentials
ID: DB_PASS, MYSQL_ROOT_PASSWORD etc.

2. Pipeline mein Use Kar:

environment {
DB_PASS = credentials('DB_PASS')
MYSQL_ROOT_PASSWORD = credentials('MYSQL_ROOT_PASSWORD')
}

BEST Approach - .env File Use Kar:

stage('Build And Run') {
steps {
// .env file ko Jenkins agent par load kar
sh "docker compose up -d --build"
}
}

.env file GitHub par upload mat kar but Jenkins server par rakh.

Tere Ke Liye Recommendation:

Ab jo hardcode kar diya, chal jayega locally.

PAR Production ke liye:

Jenkins Credentials use kar ☝️ (SAHI TARIKA)
Passwords change kar (existing passwords exposed ho gaye hain GitHub par)
.env file securely manage kar

Abhi Kya Status Hai?

✅ Locally testing ke liye OK hai
⚠️ Production ready nahi hai
🔒 Passwords secure karne ke liye Jenkins Credentials use kar

Sab theek hai? 👍
