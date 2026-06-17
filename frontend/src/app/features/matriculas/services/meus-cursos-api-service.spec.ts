import { TestBed } from '@angular/core/testing';

import { MeusCursosApiService } from './meus-cursos-api-service';

describe('MeusCursosApiService', () => {
  let service: MeusCursosApiService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(MeusCursosApiService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
