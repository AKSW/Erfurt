node {
   stage 'Checkout'
   checkout scm

   stage 'Debug Output'
   sh 'uname -r'
   sh 'php --version'

   stage 'Prepare Build'
   sh 'composer install --no-interaction'
   sh 'make directories'
   sh 'make test-clean'

   stage 'Unit Tests'
   sh 'composer unittest'

   stage 'Integration Tests'
   sh 'composer test'
}