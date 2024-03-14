import { Injectable } from '@angular/core';
import { ActivatedRouteSnapshot, CanActivate, CanActivateFn, Router } from '@angular/router';
import { Observable, map, of } from 'rxjs';
import { AuthService } from './services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class Auth2Guard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot): Observable<boolean> {
    const token = localStorage.getItem('token');
    if (!token) {
      this.router.navigate(['/login']);
      return of(false);
    }

    return this.authService.verifyToken(token).pipe(
      map((response) => {
        if (response.isActive) {
          return true;
        } else {
          this.router.navigate(['/unauthorized']);
          return false;
        }
      })
    );
  }
}


