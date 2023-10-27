<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;

class usersExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection() {
        // For exporting complete table
        //return User::all();
        // For Exporting selected columns
        $users = User::select('id','name','address','city','state','country','pincode','mobile','email', 'created_at')->where('status', 1)->orderBy('id', 'Desc')->get();
        return $users;
    }

    public function headings():array {
        return ['ID', 'Name', 'Address', 'City', 'State', 'Country', 'Pincode', 'Mobile', 'Email', 'Registered on'];
    }
}
