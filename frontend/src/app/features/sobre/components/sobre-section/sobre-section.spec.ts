import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SobreSection } from './sobre-section';

describe('SobreSection', () => {
  let component: SobreSection;
  let fixture: ComponentFixture<SobreSection>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SobreSection]
    })
    .compileComponents();

    fixture = TestBed.createComponent(SobreSection);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
