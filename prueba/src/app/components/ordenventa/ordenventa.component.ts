import { Component, OnInit } from '@angular/core';
import { OrdenVentaService } from '../../services/orden-venta.service';
import { ApiResponse5, OrdenVenta } from '../../Interfaces/api-response';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { UsersService } from '../../services/users.service';
import { User } from '../../Interfaces/user-interface';
@Component({
  selector: 'app-ordenventa',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule, ReactiveFormsModule],
  templateUrl: './ordenventa.component.html',
  styleUrl: './ordenventa.component.css'
})
export class OrdenVentaComponent implements OnInit {

  ordenesVenta: OrdenVenta[] = [];
  nuevaOrden: OrdenVenta = { id: 0, fecha_orden: new Date(), estado: '', user: 0, tipo_venta: '' };
  mensaje: string | null = null;
  ordenEditada: OrdenVenta | null = null;
  users: User[] | undefined;

  constructor(private ordenVentaService: OrdenVentaService, private userService: UsersService) { }

  ngOnInit(): void {
    this.cargarOrdenesVenta();
    this.loadUsers();
  }

  loadUsers(): void {
    this.userService.getUsers().subscribe(response => {
      this.users = response['data: '];
    });
  }

  getUserName(id: number): string {
    const User = this.users?.find(User => User.id === id);
    return User ? User.name : '';
  }
  

  cargarOrdenesVenta(): void {
    const token = localStorage.getItem('token') || '';
    this.ordenVentaService.getOrdenesVenta(token).subscribe((response: ApiResponse5) => {
      this.ordenesVenta = response['data :'] || [];
      console.log(response);
    });
  }

  agregarOrdenVenta(): void {
    const token = localStorage.getItem('token') || '';
    this.ordenVentaService.addOrdenVenta(this.nuevaOrden, token).subscribe(
      response => {
        this.cargarOrdenesVenta();
        this.mensaje = response.msg;
        // Limpiar campos u otro manejo necesario
      },
      error => {
        this.mensaje = 'Error al agregar orden de venta. Por favor, inténtelo de nuevo.';
      }
    );
  }

  editarOrdenVenta(ordenVenta: OrdenVenta): void {
    this.ordenEditada = { ...ordenVenta };
  }

  actualizarOrdenVenta(): void {
    if (this.ordenEditada) {
      const token = localStorage.getItem('token') || '';
      this.ordenVentaService.updateordenventa( this.ordenEditada, token).subscribe(
        response => {
          this.cargarOrdenesVenta();
          this.ordenEditada = null;
          this.mensaje = response.msg;
        },
        error => {
          this.mensaje = 'Error al actualizar orden de venta. Por favor, inténtelo de nuevo.';
        }
      );
    }
  }

  eliminarOrdenVenta(id: number): void {
    const token = localStorage.getItem('token') || '';
    this.ordenVentaService.deleteordenventa(id , token).subscribe(
      response => {
        this.cargarOrdenesVenta();
        this.mensaje = response.msg;
      },
      error => {
        this.mensaje = 'Error al eliminar orden de venta. Por favor, inténtelo de nuevo.';
      }
    );
  }

  cancelarEdicion(): void {
    this.ordenEditada = null;
  }
}
