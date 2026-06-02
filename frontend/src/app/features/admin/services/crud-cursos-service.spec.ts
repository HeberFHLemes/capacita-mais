import { TestBed } from '@angular/core/testing';

import { AdminCursosApiService } from './crud-cursos-service';

describe('CrudCursosService', () => {
  let service: AdminCursosApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AdminCursosApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
