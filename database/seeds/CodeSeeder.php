<?php

use Vanguard\Code;
use Illuminate\Database\Seeder;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Code::create([
            'code_type' => 'EMP_SIZE',
            'code' => '0-10',
            'description' => '0-10 employees',
        ]);

        Code::create([
            'code_type' => 'EMP_SIZE',
            'code' => '10-50',
            'description' => '10-50 employees',
        ]);

        Code::create([
            'code_type'=>'EMP_SIZE',
            'code' => '50-100',
            'description' => '50-100 employees',
        ]);

        Code::create([
            'code_type' => 'EMP_SIZE',
            'code' => '100-200',
            'description' => '100-200 employees',
        ]);

        Code::create([
            'code_type' => 'EMP_SIZE',
            'code' => '200-500',
            'description' => '200-500 employees',
        ]);

        Code::create([
            'code_type'=>'EMP_SIZE',
            'code' => '500-1000',
            'description' => '500-1000 employees',
        ]);
        Code::create([
            'code_type' => 'EMP_SIZE',
            'code' => '1000-5000',
            'description' => '1000-5000 employees',
        ]);

        Code::create([
            'code_type'=>'EMP_SIZE',
            'code' => '5000 Above',
            'description' => '5000 Above',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Medical_Centre',
            'description' => 'Medical Centre',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Medical_Clinic',
            'description' => 'Medical Clinic',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Hospital',
            'description' => 'Hospital',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Hospitalship',
            'description' => 'Hospitalship',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Health_System',
            'description' => 'Health System',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Legal_Firm',
            'description' => 'Legal Firm',
        ]);
        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Accounting/Bookeeping_Firm',
            'description' => 'Accounting/ Bookeeping Firm',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Educational_Institution',
            'description' => 'Educational Institution',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Medical_Association/Society/Boards',
            'description' => 'Medical Association/ Society/ Boards',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Publication_Company',
            'description' => 'Publication Company',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Consulting_Firm',
            'description' => 'Consulting Firm',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Medical_Coding_Billing',
            'description' => 'Medical Coding and Billing',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'RCM_Provider',
            'description' => 'RCM Provider',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Nursing_Home',
            'description' => 'Nursing Home',
        ]);
        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Health_Insurance_Company',
            'description' => 'Health Insurance Company',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Assisted_Living',
            'description' => 'Assisted Living',
        ]);
        

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Physician_Group',
            'description' => 'Physician Group',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Home_Health',
            'description' => 'Home Health',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Pharmacy',
            'description' => 'Pharmacy',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Hospice',
            'description' => 'Hospice',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Emergency_Medical_Services',
            'description' => 'Emergency Medical Services',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Ambulatory Care',
            'description' => 'Ambulatory Care',
        ]);

        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Retails_Clinic',
            'description' => 'Retails Clinic',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Health_IT_and_Software_Solutions',
            'description' => 'Health IT and Software Solutions',
        ]);
        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Medical_Lab_Diagnosis',
            'description' => 'Medical Lab and Diagnosis',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Government_Agency',
            'description' => 'Government Agency',
        ]);
        
        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Individual_Practice',
            'description' => 'Individual Practice',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Rehab_Mental_Health',
            'description' => 'Rehab and Mental Health',
        ]);
        Code::create([
            'code_type' => 'EMP_SPEC',
            'code' => 'Fitness_Wellness',
            'description' => 'Fitness and Wellness',
        ]);

        Code::create([
            'code_type'=>'EMP_SPEC',
            'code' => 'Medical_Equipment',
            'description' => 'Medical Equipment',
        ]);
        
    }
}
