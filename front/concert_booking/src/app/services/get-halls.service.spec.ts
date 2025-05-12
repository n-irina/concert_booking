import { TestBed } from '@angular/core/testing';

import { GetHallsService } from './get-halls.service';

describe('GetHallsService', () => {
  let service: GetHallsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GetHallsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
