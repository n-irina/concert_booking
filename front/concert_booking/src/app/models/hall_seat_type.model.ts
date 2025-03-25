import { Hall } from "./hall.model";
import { SeatType } from "./seat_type.model";

export interface HallSeatType{

  "@id": string,
  "@type": string,
  "id": number,
  "capacity": number,
  "hall": Hall,
  "seat_type": SeatType,

}