import { TestBed } from '@angular/core/testing';

import { CrudCursosService } from './crud-cursos-service';

describe('CrudCursosService', () => {
  let service: CrudCursosService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CrudCursosService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
