node {
   stage('Checkout') {
      checkout scm
   }

   stage('Debug Output') {
      sh 'uname -r'
      sh 'php --version'
   }

   stage('Prepare Build') {
      sh 'composer install --no-interaction'
      sh 'make directories'
      sh 'make test-clean'
      sh 'cp -f /configs/config.ini tests/config.ini'
   }

   stage('Run Tests') {
      sh 'composer test'
   }
}