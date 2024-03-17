// services/device.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Device } from '../Interfaces/device';

@Injectable({
  providedIn: 'root'
})
export class DeviceService {
  private apiUrl = 'http://127.0.0.1:8000/api/auth';

  constructor(private http: HttpClient) {}

  getDevices(token: string): Observable<Device[]> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    });
    return this.http.get<Device[]>(`${this.apiUrl}/getdispositivos`, { headers });
  }

  addDevice(device: Device, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    });
    return this.http.post(`${this.apiUrl}/postdispositivos`, device, { headers });
  }

  updateDevice(device: Device, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    });
    return this.http.put(`${this.apiUrl}/putdispositivos/${device.id}`, device, { headers });
  }

  deleteDevice(id: number, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
    });
    return this.http.delete(`${this.apiUrl}/deletedispositivos/${id}`, { headers });
  }
}
