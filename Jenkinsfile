pipeline {
    
    agent none
    
    stages {
        stage('git repo') {
            agent { label 'agent-lftp' }
            steps {
                git branch: 'main', url: 'https://github.com/st-ac/TP_backend_deployment_cda' 
            }
        }
        stage('sonarqube') {
            agent { label 'agent-php' }
            steps {
                sh """
            sonar-scanner \
            -Dsonar.projectKey=steph_tp_back \
            -Dsonar.sources=. \
            -Dsonar.host.url=https://669b-212-114-26-208.ngrok-free.app \
            -Dsonar.token=sqp_0dd3e4413529e84bc9da617d9dd06e4fb79f8d15
            """
            }
        }
            stage('lftp') {
            agent { label 'agent-lftp' }
            steps {
            sh '''
            lftp -u "$login1","$mdp" -e "mirror -R ${WORKSPACE}/ www/; quit" "$ftp"
            '''
            }
            }

stage('dependancies') {
            agent { label 'agent-php' }
            steps {
                sh '''
                sshpass -p "$mdp" ssh -o StrictHostKeyChecking=no "$loginssh" '
                cd ~/www &&
                composer install --no-dev
                '
                '''
            }
        }
stage('SSH and .env') {
    agent { label 'agent-php' }
    steps {
        sh '''
        sshpass -p "$mdp" ssh -o StrictHostKeyChecking=no "$loginssh" "cat > www/.env << 'EOF'
        ${credentials}"
'''
    }
}
stage('migration') {
 agent { label 'agent-php' }
 steps {
     sh '''
        sshpass -p "$mdp" ssh -o StrictHostKeyChecking=no "$loginssh" 'cd www/ && php migrate.php'
        '''
     
 }
}
    }
}
