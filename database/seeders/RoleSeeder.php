<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Cajero']);
        
        Permission::create(['name' => 'negocio.edit','description' => 'Editar datos del negocio'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'usuarios.index','description' => 'Ver Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.create','description' => 'Crear Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.edit','description' => 'Editar Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'usuarios.destroy','description' => 'Eliminar Usuarios'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'categories.index','description' => 'Ver categorías'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'categories.create','description' => 'Crear categorías'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.edit','description' => 'Editar categorías'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.destroy','description' => 'Eliminar categorías'])->syncRoles([$role1]);

        Permission::create(['name' => 'proveedores.index','description' => 'Ver proveedores'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'proveedores.create','description' => 'Crear proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'proveedores.edit','description' => 'Editar proveedores'])->syncRoles([$role1]);
        Permission::create(['name' => 'proveedores.destroy','description' => 'Eliminar proveedores'])->syncRoles([$role1]);
       
        Permission::create(['name' => 'productos.index','description' => 'Ver productos'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'productos.create','description' => 'Crear productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'productos.edit','description' => 'Editar productos'])->syncRoles([$role1]);
       
        Permission::create(['name' => 'log','description' => 'Ver actividad en el sistema'])->syncRoles([$role1]);

        Permission::create(['name' => 'menu.reportes','description' => 'Mostrar menú de reportes'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'menu.altas','description' => 'Mostrar menú de reporte de altas'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'menu.roles-permisos','description' => 'Mostrar menú de roles y permisos'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'reporte.productos','description' => 'Ver reporte de altas de productos'])->syncRoles([$role1]);
        Permission::create(['name' => 'reporte.usuarios','description' => 'Ver reporte de altas de usuarios'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'reporte.ventas','description' => 'Ver historial de ventas'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'reporte.apartados','description' => 'Ver historial de apartados'])->syncRoles([$role1,$role2]);
        
        Permission::create(['name' => 'roles.index','description' => 'Ver roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.create','description' => 'Crear roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.edit','description' => 'Editar roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.destroy','description' => 'Eliminar roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'permisos.index','description' => 'Ver permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.edit','description' => 'Editar permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'permisos.destroy','description' => 'Eliminar permisos'])->syncRoles([$role1]);

        Permission::create(['name' => 'venta.index','description' => 'Realizar venta'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'venta.edit','description' => 'Modificar venta'])->syncRoles([$role1]);
        Permission::create(['name' => 'venta.destroy','description' => 'Cancelar venta'])->syncRoles([$role1]);

        Permission::create(['name' => 'apartado.index','description' => 'Realizar apartado'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'apartado.edit','description' => 'Modificar apartado'])->syncRoles([$role1]);
        Permission::create(['name' => 'apartado.destroy','description' => 'Cancelar apartado'])->syncRoles([$role1]);

    }
}
