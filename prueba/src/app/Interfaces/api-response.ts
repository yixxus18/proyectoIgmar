
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
