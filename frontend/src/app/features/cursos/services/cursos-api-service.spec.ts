import { TestBed } from '@angular/core/testing';

import { CursosApiService } from './cursos-api-service';

describe('CursosApiService', () => {
  let service: CursosApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CursosApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
