import { Routes, CanActivate } from '@angular/router';
import { RegisterComponent } from './components/users/register/register.component';
import { LoginComponent } from './components/users/login/login.component';
import { AuthGuard } from './authguard.guard';
import { CrudComponent } from './components/users/crud/crud.component';
import { Auth2Guard } from './auth2.guard';
import { VerificacionComponent } from './components/verificacion/verificacion/verificacion.component';

export const routes: Routes = [
    { path: '', redirectTo: 'register', pathMatch: 'full' },
    { path: 'register', loadComponent:()=>import('./components/users/register/register.component').then(m=>m.RegisterComponent)},
    { path: 'login', loadComponent:()=>import('./components/users/login/login.component').then(m=>m.LoginComponent)},
    { path: 'verificacion', loadComponent:()=>import('./components/verificacion/verificacion/verificacion.component').then(m=>m.VerificacionComponent)},
    {
      path: 'index',
      loadComponent: () => import('./components/index/index.component').then(m => m.IndexComponent),
      canActivate: [Auth2Guard],
      children: [
        {
          path: 'crud',
          loadComponent: () => import('./components/users/crud/crud.component').then(m => m.CrudComponent),
          canActivate: [AuthGuard],
          data: {role: [1]}
        }
      ]
    }    
  ];