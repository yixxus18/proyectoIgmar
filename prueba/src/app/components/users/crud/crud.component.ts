import { Component, ViewChild , ElementRef , AfterViewInit } from '@angular/core';
import { User } from '../../../Interfaces/user-interface';
import { UsersService } from '../../../services/users.service';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../../services/auth.service';
import { RegisterComponent } from "../register/register.component";
import { AgregarusersComponent } from './agregarusers/agregarusers.component';
import { EditComponent } from "./edit/edit.component";
declare var $: any;
@Component({
    selector: 'app-crud',
    standalone: true,
    templateUrl: './crud.component.html',
    styleUrl: './crud.component.css',
    imports: [RouterModule, CommonModule, RegisterComponent, AgregarusersComponent, EditComponent]
})
export class CrudComponent {
  users: User[] | undefined;
  rolUsuario: number = 0;


  constructor(private userService: UsersService, private AuthService: AuthService) { }

  ngOnInit(): void {
    this.loadUsers();
    this.loadUserRole();
  }

  loadUsers(): void {
    this.userService.getUsers().subscribe(response => {
      this.users = response['data: '];
    });
  }

  loadUserRole(): void {
    const token = localStorage.getItem('token');
    if (token) {
      this.AuthService.verifyToken(token).subscribe(response => {
        this.rolUsuario = response['tipo usuario'];
      });
    }
  }

  adduser(): void {
    this.loadUsers();
  }

  editUser(user: User): void {
    // Implementar lógica de edición aquí
    console.log('Editar usuario:', user);
  }

  confirmDeleteUser(userId: number): void {
    if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
      this.deleteUser(userId);
    }
  }

  deleteUser(userId: number): void {
    const token = localStorage.getItem('token');
    if (token) {
      this.userService.deleteUser(userId, token).subscribe(() => {
        alert('Usuario eliminado correctamente');
        this.loadUsers(); // Recargar la lista de usuarios después de eliminar
      }, error => {
        console.error('Error al eliminar usuario:', error);
        alert('Error al eliminar usuario. Por favor, inténtalo de nuevo.');
      });
    }
  }

}
