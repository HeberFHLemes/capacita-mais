import { Component } from '@angular/core';
import { AdminNav } from '../admin-nav/admin-nav';

@Component({
  selector: 'app-admin-sidebar-offcanvas',
  standalone: true,
  imports: [AdminNav],
  templateUrl: './admin-sidebar-offcanvas.html',
  styleUrl: './admin-sidebar-offcanvas.css',
})
export class AdminSidebarOffcanvas {

}
