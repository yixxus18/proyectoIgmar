// components/devices/devices.component.ts
import { Component, OnInit } from '@angular/core';
import { Device } from '../../Interfaces/device';
import { DeviceService } from '../../services/device.service';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-devices',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './devices.component.html',
  styleUrls: ['./devices.component.css']
})
export class DevicesComponent implements OnInit {
  newDevice: Device = { id: 0, marca: '', modelo: '', tipo_dispositivos: '' };
  devices: Device[] | undefined;
  message: string | null = null;
  rolUsuario: number = 0;
  selectedDevice: Device | null = null;
  tempDevice: Device | null = null;
  registerMessage: string | null = null;

  constructor(private deviceService: DeviceService, private authService: AuthService) {}

  ngOnInit(): void {
    this.loadDevices();
    this.loadUserRole();
  }

  loadDevices(): void {
    const token = localStorage.getItem('token') || '';
    this.deviceService.getDevices(token).subscribe(devices => {
      this.devices = devices;
    });
  }

  loadUserRole(): void {
    const token = localStorage.getItem('token');
    if (token) {
      this.authService.verifyToken(token).subscribe(response => {
        this.rolUsuario = response['tipo usuario'];
      });
    }
  }

  addDevice(newDeviceValue: Device): void {
    const token = localStorage.getItem('token') || '';
    this.deviceService.addDevice(newDeviceValue, token).subscribe(
      response => {
        this.loadDevices();
        this.registerMessage = response.msg;
        this.message = response.msg;
      },
      error => {
        this.registerMessage = 'Error al agregar dispositivo. Por favor, inténtelo de nuevo.';
        this.message = error.error.msg;
      }
    );
  }

  editDevice(device: Device): void {
    this.selectedDevice = device;
    this.tempDevice = { ...device };
  }

  updateDevice(): void {
    const token = localStorage.getItem('token') || '';
    if (this.tempDevice) {
      this.deviceService.updateDevice(this.tempDevice, token).subscribe(
        response => {
          this.loadDevices();
          this.selectedDevice = null;
          this.tempDevice = null;
          this.registerMessage = response.msg;
          this.message = response.msg;
        },
        error => {
          this.registerMessage = 'Error al actualizar dispositivo. Por favor, inténtelo de nuevo.';
          this.message = error.error.msg;
        }
      );
    }
  }

  deleteDevice(id: number): void {
    const token = localStorage.getItem('token') || '';
    this.deviceService.deleteDevice(id, token).subscribe(
      response => {
        this.loadDevices();
        this.registerMessage = response.msg;
        this.message = response.msg;
      },
      error => {
        this.registerMessage = 'Error al eliminar dispositivo. Por favor, inténtelo de nuevo.';
        this.message = error.error.msg;
      }
    );
  }

  cancelEdit(): void {
    this.selectedDevice = null;
    this.tempDevice = null;
  }
}
