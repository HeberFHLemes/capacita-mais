import { Component, computed, inject } from '@angular/core';
import { Router, RouterLink, RouterLinkActive } from '@angular/router';
import { AuthService } from '../../../features/auth/services/auth-service';

interface NavItem {
  label: string;
  rota?: string;
  acao?: 'logout' | 'abrirCarrinho';
  icone?: string;
}

enum IconeNavbar {
  HOME = 'bi bi-house',
  LOGIN = 'bi bi-box-arrow-in-right',
  CARRINHO = 'bi bi-cart3',
  CURSOS = 'bi bi-mortarboard',
  ADMIN = 'bi bi-person-gear',
  LOGOUT = 'bi bi-box-arrow-right',
}

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink, RouterLinkActive],
  templateUrl: './navbar.html',
  styleUrl: './navbar.css',
})
export class Navbar {

  readonly authService: AuthService = inject(AuthService);
  readonly router: Router = inject(Router);

  logout(): void {
    this.authService.logout();
    this.router.navigate(['/']);
  }

  executarAcao(acao: 'logout'|'abrirCarrinho'): void {
    if (acao === 'logout') {
      this.logout();
    } else {
      this.abrirCarrinho();
    }
  }

  abrirCarrinho(): void {
    // TODO: abrir aside do carrinho de compras do usuário
  }

  readonly itensNavbar = computed<NavItem[]>(() => {
    let navItems: NavItem[] = [];

    navItems.push(
      {
        label: 'Início',
        rota: '/',
        icone: IconeNavbar.HOME
      }
    );

    if (!this.authService.isUsuarioAutenticado()) {
      navItems.push(
        {
          label: 'Entrar',
          rota: '/login',
          icone: IconeNavbar.LOGIN
        }
      );
      return navItems;
    }

    if (this.authService.isAdmin()) {
      navItems.push(
        {
          label: 'Área administrativa',
          rota: '/admin',
          icone: IconeNavbar.ADMIN
        }
      )
    } else {
      navItems.push(
        {
          label: 'Meus cursos',
          rota: '/meus-cursos',
          icone: IconeNavbar.CURSOS
        },
        {
          label: 'Meu carrinho',
          acao: 'abrirCarrinho',
          icone: IconeNavbar.CARRINHO
        },
      );
    }

    navItems.push(
      {
        label: 'Sair',
        acao: 'logout',
        icone: IconeNavbar.LOGOUT
      }
    );

    return navItems;
  });
}
