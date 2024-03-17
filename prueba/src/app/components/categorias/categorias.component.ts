import { Component, OnInit } from '@angular/core';
import { Category } from '../../Interfaces/category';
import { CategoryService } from '../../services/category.service';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { ServerResponse } from '../../Interfaces/server-respone';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-categories',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './categorias.component.html',
  styleUrls: ['./categorias.component.css']
})
export class CategoriesComponent implements OnInit {
  
  newCategory: Category = { id: 0, tipo_categoria: '' };
  categories: Category[] | undefined;
  message: string | null = null;
  rolUsuario: number = 0;
  selectedCategory: Category | null = null;
  tempCategory: Category | null = null;  // Agrega esta línea
  registerMessage: string | null = null;  // Agrega esta línea

  constructor(private categoryService: CategoryService, private AuthService: AuthService) {}

  ngOnInit(): void {
    this.loadCategories();
    this.loadUserRole();
  }

  loadCategories(): void {
    const token = localStorage.getItem('token') || '';
    this.categoryService.getCategories(token).subscribe((categories: ServerResponse) => {
      this.categories = categories['data :'];
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
  
  

  addCategory(newCategoryValue: string): void {
    const token = localStorage.getItem('token') || '';
    const newCategory: Category = { id: 0, tipo_categoria: newCategoryValue };
    this.categoryService.addCategory(newCategory, token).subscribe(
      response => {
        this.loadCategories();
        this.registerMessage = response.msg;  
        this.message = response.msg;
      },
      error => {
        this.registerMessage = 'Error al agregar categoría. Por favor, inténtelo de nuevo.';
        this.message = error.error.msg; // Mostrar mensaje de error de la API
      }
    );
  }
  
  

  editCategory(category: Category): void {
    this.selectedCategory = category;
    this.tempCategory = { ...category };
     // Copia la categoría seleccionada
  }

  updateCategory(): void {
    const token = localStorage.getItem('token') || '';
    if (this.tempCategory) {
      this.categoryService.updateCategory(this.tempCategory, token).subscribe(
        response => {
          this.loadCategories();
          this.selectedCategory = null;
          this.tempCategory = null;
          this.registerMessage = response.msg;
          this.message = response.msg;
        },
        error => {
          this.registerMessage = 'Error al actualizar categoría. Por favor, inténtelo de nuevo.';
          this.message = error.error.msg; 
          // Mostrar mensaje de error de la API
        }
      );
    }
  }
  

  deleteCategory(id: number): void {
    const token = localStorage.getItem('token') || '';
    this.categoryService.deleteCategory(id, token).subscribe(
      response => {
        this.loadCategories();
        this.registerMessage = response.msg; 
        this.message = response.msg;
      },
      error => {
        this.registerMessage = 'Error al eliminar categoría. Por favor, inténtelo de nuevo.';
        this.message = error.error.msg; // Mostrar mensaje de error de la API
      }
    );
  }

  cancelEdit(): void {
    this.selectedCategory = null;
    this.tempCategory = null;  // Limpia tempCategory
  }
}

