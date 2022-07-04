<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    
    public function run()
    {
       
      $superAdmin = Role::create(['name' => 'SuperAdmin']);
      $admin = Role::create(['name' => 'Admin']);
      $vendedor = Role::create(['name' => 'Vendedor']);
      $chofer = Role::create(['name' => 'Chofer']);
      $cliente = Role::create(['name' => 'Cliente']);

      Permission::create(['name' => 'admin.home','description'=>'Ver el dashboard'])->syncRoles([$superAdmin,$admin,$vendedor,$cliente]);

      Permission::create(['name' => 'admin.index','description'=>'Ver panel'])->syncRoles([$superAdmin,$admin,$vendedor,]);
      Permission::create(['name' => 'admin.roles.index','description'=>'Ver roles'])->syncRoles([$superAdmin]);


      Permission::create(['name' => 'admin.users.index','description'=>'Ver listado de usuarios'])->syncRoles([$superAdmin]);
      Permission::create(['name' => 'admin.users.edit','description'=>'Asignar rol'])->syncRoles([$superAdmin]);

      Permission::create(['name' => 'admin.permissions.index','description'=>'Ver listado de permisos'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.permissions.show','description'=>'Ver permisos'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.permissions.create','description'=>'Crear permisos'])->syncRoles([$superAdmin ]);
      Permission::create(['name' => 'admin.permissions.edit','description'=>'Editar permisos'])->syncRoles([$superAdmin ]);
      Permission::create(['name' => 'admin.permissions.destroy','description'=>'Eliminar permisos'])->syncRoles([$superAdmin]);

      Permission::create(['name' => 'admin.categories.index','description'=>'Ver listado de categorias'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.categories.show','description'=>'Ver  categorias'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.categories.create','description'=>'Crear categorias'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.categories.edit','description'=>'Editar categorias'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.categories.destroy','description'=>'Eliminar categorias'])->syncRoles([$superAdmin, $admin ]);

      Permission::create(['name' => 'admin.brands.index','description'=>'Ver listado de marcas'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.brands.show','description'=>'Ver  marcas'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.brands.create','description'=>'Crear marcas'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.brands.edit','description'=>'Editar marcas'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.brands.destroy','description'=>'Eliminar marcas'])->syncRoles([$superAdmin, $admin ]);

      Permission::create(['name' => 'admin.suppliers.index','description'=>'Ver listado de proveedores'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.suppliers.show','description'=>'Ver  proveedores'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.suppliers.create','description'=>'Crear proveedores'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.suppliers.edit','description'=>'Editar proveedores'])->syncRoles([$superAdmin, $admin ]);
      Permission::create(['name' => 'admin.suppliers.destroy','description'=>'Eliminar proveedores'])->syncRoles([$superAdmin, $admin ]);

      Permission::create(['name' => 'admin.tags.index','description'=>'Ver listado de etiquetas'])->syncRoles([$superAdmin, $admin]);
      Permission::create(['name' => 'admin.tags.create','description'=>'Crear etiquetas'])->syncRoles([$superAdmin, $admin]);
      Permission::create(['name' => 'admin.tags.edit','description'=>'Editar etiquetas'])->syncRoles([$superAdmin, $admin]);
      Permission::create(['name' => 'admin.tags.destroy','description'=>'Eliminar etiquetas'])->syncRoles([$superAdmin, $admin]);

      Permission::create(['name' => 'admin.products.index','description'=>'Ver listado de productos'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.products.details','description'=>'Detalle de productos'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.products.movements','description'=>'Movimientos de productos'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.products.show','description'=>'Ver productos'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.products.create','description'=>'Crear productos'])->syncRoles([ $superAdmin, $admin]);
      Permission::create(['name' => 'admin.products.edit','description'=>'Editar productos'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.products.destroy','description'=>'Eliminar productos'])->syncRoles([ $superAdmin, $admin ]);

      Permission::create(['name' => 'admin.purchases.index','description'=>'Ver listado de compras'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.purchases.details','description'=>'Ver detalle de compras'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.purchases.show','description'=>'Ver compra'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.purchases.create','description'=>'Crear compra'])->syncRoles([ $superAdmin, $admin]);
      Permission::create(['name' => 'admin.purchases.edit','description'=>'Editar compra'])->syncRoles([ $superAdmin, $admin ]);
      Permission::create(['name' => 'admin.purchases.destroy','description'=>'Eliminar compra'])->syncRoles([ $superAdmin, $admin ]);

      Permission::create(['name' => 'admin.addresses.index','description'=>'Ver listado de direcciones'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.addresses.show','description'=>'Ver direcciones'])->syncRoles([ $superAdmin, $admin , $vendedor]);
      Permission::create(['name' => 'admin.addresses.create','description'=>'Crear direcciones'])->syncRoles([ $superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.addresses.edit','description'=>'Editar direcciones'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.addresses.destroy','description'=>'Eliminar direcciones'])->syncRoles([ $superAdmin, $admin ]);

      Permission::create(['name' => 'admin.customers.index','description'=>'Ver listado de clientes'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.customers.show','description'=>'Ver clientes'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.customers.create','description'=>'Crear clientes'])->syncRoles([ $superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.customers.edit','description'=>'Editar clientes'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.customers.destroy','description'=>'Eliminar clientes'])->syncRoles([ $superAdmin, $admin ]);

      Permission::create(['name' => 'admin.orders.index','description'=>'Ver listado de pedidos'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.orders.show','description'=>'Ver pedidos'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.orders.create','description'=>'Crear pedidos'])->syncRoles([ $superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.orders.edit','description'=>'Editar pedidos'])->syncRoles([ $superAdmin, $admin, $vendedor ]);
      Permission::create(['name' => 'admin.orders.destroy','description'=>'Eliminar pedidos'])->syncRoles([ $superAdmin, $admin, $vendedor ]);

      Permission::create(['name' => 'admin.sales.index','description'=>'Ver listado de ventas'])->syncRoles([$superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.sales.create','description'=>'Crear ventas'])->syncRoles([$superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.sales.edit','description'=>'Editar ventas'])->syncRoles([$superAdmin, $admin, $vendedor]);
      Permission::create(['name' => 'admin.sales.destroy','description'=>'Eliminar ventas'])->syncRoles([$superAdmin, $admin, $vendedor]);

      Permission::create(['name' => 'admin.deliveries.index','description'=>'Ver listado de repartos'])->syncRoles([$superAdmin, $admin, $chofer]);
      Permission::create(['name' => 'admin.deliveries.create','description'=>'Crear repartos'])->syncRoles([$superAdmin, $admin, $chofer]);
      Permission::create(['name' => 'admin.deliveries.edit','description'=>'Editar repartos'])->syncRoles([$superAdmin, $admin, $chofer]);
      Permission::create(['name' => 'admin.deliveries.destroy','description'=>'Eliminar repartos'])->syncRoles([$superAdmin, $admin, $chofer]);


      
    }
}
