import { Component } from '@angular/core';
import { AdminNav } from '../admin-nav/admin-nav';

@Component({
  selector: 'app-admin-sidebar',
  standalone: true,
  imports: [AdminNav],
  templateUrl: './admin-sidebar.html',
  styleUrl: './admin-sidebar.css',
})
export class AdminSidebar {

}
