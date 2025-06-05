pipeline {
    
    agent none
    
    stages {
        stage('git repo') {
            agent { label 'agent-lftp' }
            steps {
                git branch: 'main', url: 'https://github.com/st-ac/TP_backend_deployment_cda' 
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
