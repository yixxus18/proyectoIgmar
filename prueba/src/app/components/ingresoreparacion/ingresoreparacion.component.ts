import { Component, OnInit } from '@angular/core';
import { ApiResponse8, IngresoReparacion } from '../../Interfaces/api-response';
import { IngresoReparacionService } from '../../services/ingreso-reparacion.service';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-ingresoreparacion',
  standalone: true,
  imports: [CommonModule,FormsModule,RouterModule,ReactiveFormsModule],
  templateUrl: './ingresoreparacion.component.html',
  styleUrl: './ingresoreparacion.component.css'
})
export class IngresoReparacionComponent implements OnInit {
  ingresos: IngresoReparacion[] | undefined;
  nuevoIngreso: IngresoReparacion = {
    id: 0,
    user: 0,
    dispositivo: 0,
    reparacion: 0,
    descripcion: '',
    fecha_ingreso: new Date(),
    estatus: ''
  };
  mensaje: string | null = null;
  edicionActiva = false; // Variable para controlar la edición activa
  ingresoEditado: IngresoReparacion | null = null;
  ingresoEditadoBackup: IngresoReparacion | null = null;

  constructor(private ingresoReparacionService: IngresoReparacionService) {}

  ngOnInit(): void {
    this.loadIngresos();
  }

  loadIngresos(): void {
    const token = localStorage.getItem('token') || '';
    this.ingresoReparacionService.getIngresos(token).subscribe((response: ApiResponse8) => {
      this.ingresos = response['data :'];
    });
  }

  agregarIngreso(): void {
    const token = localStorage.getItem('token') || '';
    this.ingresoReparacionService.storeIngreso(this.nuevoIngreso, token).subscribe(
      response => {
        this.loadIngresos();
        this.nuevoIngreso = {
          id: 0,
          user: 0,
          dispositivo: 0,
          reparacion: 0,
          descripcion: '',
          fecha_ingreso: new Date(),
          estatus: ''
        };
        this.mensaje = response.Msg;
      },
      error => {
        this.mensaje = 'Error al agregar ingreso. Por favor, inténtelo de nuevo.';
        console.log(error);
      }
    );
  }

  editarIngreso(ingreso: IngresoReparacion): void {
    this.ingresoEditadoBackup = { ...ingreso }; // Crear copia de respaldo
    this.ingresoEditado = ingreso;
    this.edicionActiva = true; // Activar la edición
  }

  cancelarEdicion(): void {
    if (this.ingresoEditadoBackup) {
      this.ingresoEditado = { ...this.ingresoEditadoBackup }; // Restaurar desde copia de respaldo
      this.ingresoEditadoBackup = null; // Limpiar copia de respaldo
    }
    this.edicionActiva = false; // Desactivar la edición
  }

  actualizarIngreso(): void {
    if (this.ingresoEditado) {
      const token = localStorage.getItem('token') || '';
      this.ingresoReparacionService.updateIngreso(this.ingresoEditado, token).subscribe(
        response => {
          this.loadIngresos();
          this.ingresoEditado = null;
          this.ingresoEditadoBackup = null;
          this.mensaje = response.msg;
        },
        error => {
          this.mensaje = 'Error al actualizar ingreso. Por favor, inténtelo de nuevo.';
        }
      );
    }
  }

  eliminarIngreso(id: number): void {
    const token = localStorage.getItem('token') || '';
    this.ingresoReparacionService.deleteIngreso(id, token).subscribe(
      response => {
        this.loadIngresos();
        this.mensaje = response.msg;
      },
      error => {
        this.mensaje = 'Error al eliminar ingreso. Por favor, inténtelo de nuevo.';
      }
    );
  }
}
