// login.component.ts
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loading = false;
  error = '';
  userInfo: any = null;

  constructor(
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit() {
    // Tenta fazer login automático ao carregar a página
    this.autoLogin();
  }

  autoLogin() {
    this.loading = true;
    this.error = '';

    this.authService.loginWithActiveDirectory().subscribe({
      next: (response) => {
        this.loading = false;
        this.userInfo = response.user;
        // Redireciona para o dashboard após login bem-sucedido
        setTimeout(() => {
          this.router.navigate(['/dashboard']);
        }, 1500);
      },
      error: (err) => {
        this.loading = false;
        this.error = err.error?.message || 'Erro ao autenticar com Active Directory';
        console.error('Erro de autenticação:', err);
      }
    });
  }

  retry() {
    this.autoLogin();
  }
}