<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\User;
        $administrator->username = "admin";
        $administrator->name = "Administrator";
        $administrator->email = "admin@admin.test";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("larashop");
        $administrator->avatar = "saat-ini-tidak-ada-file.png";
        $administrator->address = "Malang";
        $administrator->phone = "0382873674";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }
}
