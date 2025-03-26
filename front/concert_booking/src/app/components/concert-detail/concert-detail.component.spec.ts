import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ConcertDetailComponent } from './concert-detail.component';

describe('ConcertDetailComponent', () => {
  let component: ConcertDetailComponent;
  let fixture: ComponentFixture<ConcertDetailComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ConcertDetailComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ConcertDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
