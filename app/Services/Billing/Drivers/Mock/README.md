# Billing Drivers

## This Folder contains Drivers for other third party APIs that will be used to bill users

1. All Drivers must implement the BillingInterface
2. Once a Driver is created, it can be added to Billing by creating a protected function in Billing named 'create' + DRIVER_NAME + 'Driver. This functions returns an instance of the Driver class.
3. To use created driver when billing is instantiatied, pass in Driver name - `$biller = new Billing(DRIVER_NAME);`