pipeline{
    agent any
    environment{
        staging_server="16.171.236.42"
    }
    stages{
        stage('Deploy to Remote'){
            steps{
                sh 'scp ${WORKSPACE}/* root@{staging_server}:/var/www//html/WAREHOUSEIFRANE/'
            }
        }
    }

}