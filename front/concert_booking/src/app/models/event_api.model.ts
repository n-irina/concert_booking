import { Artist } from "./artist.model";
import { Session } from "./session.model";

export interface Event_api{
  "@id": string,
  "@type": string,
  "id": number,
  "name": string,
  "description": string,
  "artist": Artist[],
  "sessions": Session[],
  "picture_path": string,
}