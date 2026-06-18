import { TestBed } from '@angular/core/testing';

import { AdminCursosApiService } from './admin-cursos-api-service';

describe('AdminCursosApiService', () => {
  let service: AdminCursosApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AdminCursosApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
