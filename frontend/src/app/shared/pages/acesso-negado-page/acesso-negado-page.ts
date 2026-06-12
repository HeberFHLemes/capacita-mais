import { Component } from '@angular/core';
import {Location} from '@angular/common';
import {Router} from '@angular/router';

@Component({
  selector: 'app-acesso-negado-page',
  standalone: true,
  templateUrl: './acesso-negado-page.html',
  styleUrl: './acesso-negado-page.css',
})
export class AcessoNegadoPage {
  constructor(
    private location: Location,
    private router: Router
  ) {}

  voltar(): void {
    if (window.history.length > 1) {
      this.location.back();
      return;
    }
    this.router.navigate(['/']);
  }
}
