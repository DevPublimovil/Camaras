<?php

class PublimovilSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->import('countries');
        $this->import('pantallas');
        $this->import('permissions');
    }
}
