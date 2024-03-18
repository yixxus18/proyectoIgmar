
import { Accesorio } from "./accesorio";
import { Device } from "./device";
import { Reparacion } from "./reparacion";
export interface ApiResponse {
  Msg: string;
  'data :': Device[];
}

export interface ApiResponse2 {
  Msg: string;
  'data :': Reparacion[]; // Aquí deberías tener el arreglo de reparaciones
}

export interface ApiResponse3 {
  Msg: string;
  'data :': Accesorio[]; // Aquí deberías tener el arreglo de reparaciones
}

// reparacion-dispositivo.ts
export interface ReparacionDispositivo {
  id: number;
  dispositivo_id: number;
  reparaciones_id: number;
  precio: string;
}

// api-response.ts
export interface ApiResponse4 {
  Msg: string;
  "data :"?: ReparacionDispositivo[];
}
