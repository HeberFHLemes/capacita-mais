import { TestBed } from '@angular/core/testing';

import { AdminCategoriasApiService } from './admin-categorias-api-service';

describe('AdminCategoriasApiService', () => {
  let service: AdminCategoriasApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AdminCategoriasApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
