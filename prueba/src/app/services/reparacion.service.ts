import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Reparacion } from '../Interfaces/reparacion';

@Injectable({
  providedIn: 'root'
})
export class ReparacionService {

  private apiUrl = 'http://127.0.0.1:8000/api/auth';

  constructor(private http: HttpClient) { }

  getReparaciones(token: string): Observable<Reparacion[]> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
    return this.http.get<Reparacion[]>(`${this.apiUrl}/getreparaciones`, { headers });
  }

  addReparacion(reparacion: Reparacion, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
    return this.http.post<any>(`${this.apiUrl}/storereparaciones`, reparacion, { headers });
  }

  updateReparacion(reparacion: Reparacion, token: string ): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
    return this.http.put<any>(`${this.apiUrl}/postreparaciones/${reparacion.id}`, reparacion, { headers });
  }

  deleteReparacion(id: number, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
    return this.http.delete<any>(`${this.apiUrl}/deletereparaciones/${id}`, { headers });
  }
}
