<?php
/**
 * Temple directory importer: 18 famous temples with original descriptions.
 *
 * All text is written fresh for epoojabooking.com. Photos are not bundled
 * for copyright reasons; upload your own or licensed images as the
 * Featured Image and attachments on each temple.
 *
 * @package epoojabooking-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Import all temples. Safe to run twice; existing slugs are skipped.
 */
function epb_import_temples() {
	foreach ( epb_temples_data() as $temple ) {
		$existing = get_page_by_path( $temple['slug'], OBJECT, 'epb_temple' );
		if ( $existing ) {
			continue;
		}

		$temple_id = wp_insert_post( array(
			'post_type'    => 'epb_temple',
			'post_status'  => 'publish',
			'post_name'    => $temple['slug'],
			'post_title'   => $temple['title'],
			'post_content' => $temple['content'],
			'post_excerpt' => $temple['excerpt'],
		) );

		if ( ! is_wp_error( $temple_id ) && $temple_id ) {
			update_post_meta( $temple_id, 'epb_city', $temple['city'] );
			update_post_meta( $temple_id, 'epb_state', $temple['state'] );
			update_post_meta( $temple_id, 'epb_deity', $temple['deity'] );
			update_post_meta( $temple_id, 'epb_darshan_timings', $temple['darshan'] );
			update_post_meta( $temple_id, 'epb_aarti_timings', $temple['aarti'] );
			update_post_meta( $temple_id, 'epb_meta_description', $temple['excerpt'] );
		}
	}
}

/**
 * Temple data. Descriptions are original writing.
 *
 * @return array[]
 */
function epb_temples_data() {
	return array(

		array(
			'slug'    => 'prem-mandir-vrindavan',
			'title'   => 'Prem Mandir',
			'city'    => 'Vrindavan',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Radha Krishna and Sita Ram',
			'darshan' => '8:30 AM to 12:00 PM, 4:30 PM to 8:30 PM',
			'aarti'   => 'Mangala Aarti 5:30 AM, Sandhya Aarti 6:30 PM',
			'excerpt' => 'A breathtaking white marble temple of divine love in Vrindavan, spread over 55 acres, where the leelas of Shri Radha Krishna come alive in carved panels and evening light shows.',
			'content' => <<<'HTML'
<p>Prem Mandir, the temple of divine love, rises in white Italian marble on the outskirts of Vrindavan. Dedicated to Shri Radha Krishna on the first level and Shri Sita Ram on the second, the temple welcomes lakhs of devotees every year who come to experience the bhakti of Braj in its most radiant form.</p>

<h2>History of the Temple</h2>
<p>The foundation was laid in January 2001 by Jagadguru Shri Kripalu Ji Maharaj, and the temple opened its doors in 2012 after more than a decade of continuous work by around a thousand artisans. Water collected from sacred tirthas across India was used in the consecration, binding the new temple to the oldest traditions of the land.</p>

<h2>Significance of the Temple</h2>
<p>The name says everything: here, prem itself is worshipped. The outer walls carry beautifully carved panels of Shri Krishna's leelas, from Govardhan leela to Maharaas, so a parikrama of the temple becomes a walk through the stories of Braj. After sunset the marble glows in changing colours, and the musical fountain in the gardens draws families to sit together in the cool evening air.</p>

<h2>What to Experience</h2>
<h3>Evening illumination</h3>
<p>Arrive before dusk. The transition of the temple from white marble to soft rainbow light is the most photographed moment in Vrindavan.</p>
<h3>Leela darshan in the gardens</h3>
<p>Life-size depictions of Krishna lifting Govardhan and dancing the Maharaas stand among the lawns, loved by children and elders alike.</p>
HTML
		),

		array(
			'slug'    => 'banke-bihari-temple-vrindavan',
			'title'   => 'Banke Bihari Temple',
			'city'    => 'Vrindavan',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Shri Banke Bihari (Krishna)',
			'darshan' => 'Summer 7:45 AM to 12:00 PM, 5:30 PM to 9:30 PM; Winter 8:45 AM to 1:00 PM, 4:30 PM to 8:30 PM',
			'aarti'   => 'Shringar Aarti at opening; Mangala Aarti only on Janmashtami',
			'excerpt' => 'The beloved temple of Thakur Banke Bihari Ji in the lanes of Vrindavan, established in 1864, where the curtain is drawn again and again because his gaze is said to be irresistible.',
			'content' => <<<'HTML'
<p>In the crowded, joyful lanes of old Vrindavan stands the temple of Banke Bihari, the form of Shri Krishna bent in three places, standing in his tribhanga pose. Few temples in India carry such an atmosphere of intimate affection between the deity and his devotees.</p>

<h2>History of the Temple</h2>
<p>The murti of Banke Bihari was revealed to Swami Haridas, the great saint and musician of the Nimbarka tradition, in Nidhivan. The present temple was built in 1864 through the devotion of the Goswami families who continue the seva today.</p>

<h2>Significance of the Temple</h2>
<p>Banke Bihari is served like a living child of the house. There are no bells in the temple, so that Thakur Ji is never startled. The curtain before the deity is drawn every few minutes, because tradition holds that a long, unbroken gaze from Bihari Ji could sweep a devotee away entirely. Darshan here comes in glimpses, and devotees say each glimpse follows you home.</p>

<h2>What to Experience</h2>
<h3>Jhanki darshan</h3>
<p>The rhythm of the opening and closing curtain, with the crowd calling out in joy at every opening, is an experience found nowhere else.</p>
<h3>Nidhivan nearby</h3>
<p>The sacred grove where Swami Haridas received Bihari Ji is a short walk away and completes the story of this temple.</p>
HTML
		),

		array(
			'slug'    => 'kaal-bhairav-temple-ujjain',
			'title'   => 'Shri Kaal Bhairav Temple',
			'city'    => 'Ujjain',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'Kaal Bhairav',
			'darshan' => '5:00 AM to 8:00 PM',
			'aarti'   => 'Morning Aarti 5:30 AM, Evening Aarti 7:00 PM',
			'excerpt' => 'The fierce guardian deity of Ujjain, where liquor is offered to Kaal Bhairav in a tradition whose mystery has never been explained, only witnessed.',
			'content' => <<<'HTML'
<p>On the banks of the Kshipra, a short ride from Mahakaleshwar, stands the temple of Kaal Bhairav, the fierce form of Lord Shiva who guards the ancient city of Ujjain. Every kotwal, or guardian, deserves respect before the king is visited, and tradition asks devotees to take darshan of Kaal Bhairav when they come to Mahakal's city.</p>

<h2>History of the Temple</h2>
<p>The temple's origins reach deep into the Puranic past, with the present structure associated with the Maratha period. Paintings in the Malwa style once decorated its walls, traces of which survive.</p>

<h2>Significance of the Temple</h2>
<p>Kaal Bhairav here accepts an offering given at almost no other temple: liquor. The cup is held to the deity's lips and the liquid visibly disappears. How this happens has never been settled, and the mystery itself has become part of the temple's power. Devotees seek Bhairav's protection from fear, enemies and the misuse of time, for Kaal means both time and death.</p>

<h2>What to Experience</h2>
<h3>The offering</h3>
<p>Stand near the sanctum during the offering and watch a tradition that has puzzled every generation of visitors.</p>
<h3>Bhairav Ashtami</h3>
<p>The temple's greatest day falls in the month of Kartik, when the guardian of Ujjain is honoured with special shringar and night-long devotion.</p>
HTML
		),

		array(
			'slug'    => 'takshakeshwar-nath-temple-prayagraj',
			'title'   => 'Takshakeshwar Nath Temple',
			'city'    => 'Prayagraj',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Lord Shiva',
			'darshan' => '5:00 AM to 12:00 PM, 4:00 PM to 9:00 PM',
			'aarti'   => 'Morning Aarti 5:30 AM, Evening Aarti 7:30 PM',
			'excerpt' => 'An ancient Shiva temple in Prayagraj linked to Takshaka, king of serpents, who is believed to have found refuge here; especially alive with devotion in the month of Sawan.',
			'content' => <<<'HTML'
<p>Near the Yamuna in Prayagraj stands Takshakeshwar Nath, an ancient temple of Lord Shiva woven together with one of the Mahabharata's most dramatic stories, the tale of Takshaka, the king of serpents.</p>

<h2>History of the Temple</h2>
<p>Tradition says that Takshaka, fleeing the snake sacrifice of King Janamejaya, took refuge in this sacred ground under Shiva's protection. The shivling here is counted among the oldest in the region, and the temple has been a center of naga worship for centuries.</p>

<h2>Significance of the Temple</h2>
<p>Because of its serpent connection, devotees come here for relief from kaal sarp dosh and for protection of the family line. In the month of Sawan the temple overflows, as kanwariyas and local devotees offer Gangajal, bilva leaves and milk to the ancient lingam. Nag Panchami is celebrated with special reverence.</p>

<h2>What to Experience</h2>
<h3>Sawan Mondays</h3>
<p>The queue moves to the sound of bol bam, and the whole neighbourhood takes on the feeling of a festival.</p>
<h3>Takshak Kund</h3>
<p>The nearby bathing spot linked to the serpent king completes the pilgrimage.</p>
HTML
		),

		array(
			'slug'    => 'kanch-mandir-indore',
			'title'   => 'Kanch Mandir',
			'city'    => 'Indore',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'Jain Tirthankaras',
			'darshan' => '5:00 AM to 12:00 PM, 4:00 PM to 8:00 PM',
			'aarti'   => 'Morning worship from 5:00 AM',
			'excerpt' => 'Indore\'s famous temple of glass, built in the early 1900s, where floors, pillars, walls and ceilings shimmer with mirror and coloured glass mosaic in every direction.',
			'content' => <<<'HTML'
<p>In the heart of Indore's old bazaar stands a temple unlike any other in India. Kanch Mandir, the temple of glass, is a Jain shrine in which nearly every surface, from the floor underfoot to the ceiling overhead, is a mosaic of mirror and coloured glass.</p>

<h2>History of the Temple</h2>
<p>The temple was built in the early twentieth century by Sir Seth Hukumchand Jain, a leading industrialist of Indore known as the cotton king. Craftsmen were brought from as far as Iran and Austria to complete the glasswork, and the result has dazzled visitors for over a hundred years.</p>

<h2>Significance of the Temple</h2>
<p>Within the shimmering interior sit serene murtis of the Jain Tirthankaras. Panels of glass mosaic depict scenes of dharma, including the consequences of good and bad deeds, so the temple teaches even as it delights the eye. Standing between its mirrored walls, a visitor sees their own reflection multiplied endlessly, a quiet lesson in how one soul is repeated in all.</p>

<h2>What to Experience</h2>
<h3>The play of light</h3>
<p>Visit in the morning when sunlight enters the hall and every wall begins to sparkle.</p>
<h3>Old Indore around you</h3>
<p>The temple sits near Sarafa Bazaar, and an evening walk through its famous food street is the perfect ending to the visit.</p>
HTML
		),

		array(
			'slug'    => 'vrindavan-chandrodaya-mandir',
			'title'   => 'Vrindavan Chandrodaya Mandir',
			'city'    => 'Vrindavan',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Shri Krishna',
			'darshan' => '9:00 AM to 8:30 PM',
			'aarti'   => 'Multiple aartis through the day',
			'excerpt' => 'A rising skyscraper temple of Shri Krishna in Vrindavan, planned to be among the tallest religious monuments in the world, with a viewing experience overlooking all of Braj.',
			'content' => <<<'HTML'
<p>Vrindavan Chandrodaya Mandir is devotion on an engineering scale India has never attempted before: a temple planned to rise around seventy floors above Braj, so that pilgrims may one day look out over the entire land of Krishna's leelas from a single darshan point.</p>

<h2>History of the Temple</h2>
<p>The project was conceived by ISKCON Bangalore as a grand offering for the modern age. Construction continues in phases, and the completed portions, including the main deity hall and the leela exhibitions, already welcome visitors from across the world.</p>

<h2>Significance of the Temple</h2>
<p>The vision joins the oldest bhakti with the newest technology. A capsule elevator is planned to carry devotees up the tower for a panoramic view of the Braj Mandal, the sacred geography of Mathura, Vrindavan, Govardhan and beyond. Around the temple, recreated forests of Vrindavan and immersive exhibitions bring the Bhagavatam's stories to life for a generation raised on screens.</p>

<h2>What to Experience</h2>
<h3>Leela exhibitions</h3>
<p>Sound and light retellings of Krishna's pastimes make this a favourite for families with children.</p>
<h3>The Braj view</h3>
<p>As construction rises, so does the promise of the most breathtaking view in all of pilgrimage India.</p>
HTML
		),

		array(
			'slug'    => 'chintaman-ganesh-temple-ujjain',
			'title'   => 'Chintaman Ganesh Temple',
			'city'    => 'Ujjain',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'Lord Ganesha',
			'darshan' => '5:00 AM to 10:00 PM',
			'aarti'   => 'Morning Aarti 5:30 AM, Evening Aarti 8:00 PM',
			'excerpt' => 'Across the Kshipra from Ujjain sits the remover of worries: Chintaman Ganesh, worshipped here in three forms, believed to free devotees from every chinta they carry.',
			'content' => <<<'HTML'
<p>Chinta means worry, and Chintaman is the Ganesha who dissolves it. Across the Kshipra river from Ujjain's old city, this ancient temple receives a steady river of devotees who arrive carrying their anxieties and leave lighter.</p>

<h2>History of the Temple</h2>
<p>The temple is counted among the oldest Ganesha shrines of Malwa, with links to the Ramayana tradition, which says the murti was established by Shri Ram, Lakshman and Sita during their years of exile. The present structure carries the marks of Maratha era renovation.</p>

<h2>Significance of the Temple</h2>
<p>Ganesha is worshipped here in three forms together: Chintaman, who removes worry, Ichchhaman, who grants wishes, and Siddhivinayak, who bestows success. Newly married couples come for blessings, families bring new vehicles and new beginnings, and on Wednesdays the courtyard fills with the fragrance of laddoos and marigold.</p>

<h2>What to Experience</h2>
<h3>The ulta swastik</h3>
<p>Devotees draw a reversed swastik on the temple wall when asking for a wish, and return to draw it straight when the wish is fulfilled.</p>
<h3>Tila Bhandara</h3>
<p>The temple's festive days during Magh month bring fairs and feasting in the old Malwa style.</p>
HTML
		),

		array(
			'slug'    => 'iskcon-vrindavan-krishna-balaram-mandir',
			'title'   => 'ISKCON Vrindavan (Krishna Balaram Mandir)',
			'city'    => 'Vrindavan',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Krishna and Balaram',
			'darshan' => '4:30 AM to 8:45 PM (midday break 1:00 PM to 4:00 PM)',
			'aarti'   => 'Mangala Aarti 4:30 AM, Sandhya Aarti 7:00 PM',
			'excerpt' => 'The Krishna Balaram Mandir at Raman Reti, founded by Srila Prabhupada in 1975, where kirtan flows without pause and devotees from every nation sing together in the land of Krishna.',
			'content' => <<<'HTML'
<p>At Raman Reti, where Krishna and Balaram are said to have played in the soft sand, stands the Sri Sri Krishna Balaram Mandir, the spiritual heart of ISKCON in India. Here the kirtan rarely stops, and the maha mantra is sung around the clock by devotees from every corner of the world.</p>

<h2>History of the Temple</h2>
<p>Srila A. C. Bhaktivedanta Swami Prabhupada, founder of the International Society for Krishna Consciousness, opened the temple in 1975, fulfilling his wish to build a home for Krishna Balaram in the dham he loved most. His samadhi in white marble stands beside the temple.</p>

<h2>Significance of the Temple</h2>
<p>The temple's three altars enshrine Gaura Nitai, Krishna Balaram, and Radha Shyamasundar. For lakhs of international devotees this temple is the gateway into Braj, and its morning program, from Mangala Aarti through Srimad Bhagavatam class, sets the model followed by ISKCON centres worldwide.</p>

<h2>What to Experience</h2>
<h3>Twenty-four hour kirtan</h3>
<p>An unbroken chain of chanting has continued here for years; sit for ten minutes and time dissolves.</p>
<h3>Prabhupada Samadhi</h3>
<p>The serene marble memorial tells the story of the saint who carried Vrindavan to the world.</p>
HTML
		),

		array(
			'slug'    => 'birla-mandir-ayodhya',
			'title'   => 'Birla Temple (Ram Janki Mandir)',
			'city'    => 'Ayodhya',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Shri Ram and Mata Janki (Sita)',
			'darshan' => '6:00 AM to 12:00 PM, 4:00 PM to 9:00 PM',
			'aarti'   => 'Morning Aarti 6:30 AM, Evening Aarti 7:30 PM',
			'excerpt' => 'A graceful Ram Janki temple built by the Birla family at the entrance of Ayodhya, welcoming pilgrims with serene darshan of Lord Ram, Mata Sita and Lakshman.',
			'content' => <<<'HTML'
<p>Standing near the entrance to the holy city, the Birla Temple of Ayodhya, properly the Ram Janki Mandir, is often a pilgrim's first darshan after arriving in the city of Shri Ram. Its calm courtyards offer a gentle beginning to the Ayodhya yatra.</p>

<h2>History of the Temple</h2>
<p>The temple belongs to the celebrated series of shrines built across India by the Birla industrialist family, patrons who paired modern construction with classical temple form. Its location near the railway station made it a natural gateway shrine for generations of pilgrims.</p>

<h2>Significance of the Temple</h2>
<p>Within the sanctum stand Shri Ram, Mata Janki and Lakshman in graceful shringar. The temple's unhurried atmosphere makes it beloved for japa and quiet sitting, a contrast to the joyful crowds of Hanuman Garhi and Ram Janmabhoomi deeper in the city. Ram Navami turns its courtyard into a sea of song.</p>

<h2>What to Experience</h2>
<h3>A peaceful first darshan</h3>
<p>Begin your Ayodhya pilgrimage here, then continue to Hanuman Garhi and the Ram Mandir with a settled heart.</p>
<h3>Ram Navami celebrations</h3>
<p>Bhajan mandalis sing through the day, and the deities receive special shringar.</p>
HTML
		),

		array(
			'slug'    => 'navgrah-shani-mandir-ujjain',
			'title'   => 'Navagraha Mandir (Triveni)',
			'city'    => 'Ujjain',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'The Nine Grahas, presided by Shani Dev',
			'darshan' => '5:00 AM to 8:00 PM',
			'aarti'   => 'Morning Aarti 6:00 AM, Evening Aarti 7:00 PM',
			'excerpt' => 'At the Triveni confluence of the Kshipra stands Ujjain\'s ancient Navagraha temple, where all nine celestial grahas are worshipped and Saturdays belong to Shani Dev.',
			'content' => <<<'HTML'
<p>Where the Kshipra meets two smaller streams at the Triveni sangam south of Ujjain stands the Navagraha Mandir, one of the rare temples where all nine grahas, the celestial influencers of Vedic astrology, are enshrined and worshipped together.</p>

<h2>History of the Temple</h2>
<p>Ujjain has been India's city of timekeeping and astronomy since antiquity; the prime meridian of classical Indian astronomy passed through it. A temple to the nine grahas at this sacred confluence continues that ancient conversation between the city and the sky.</p>

<h2>Significance of the Temple</h2>
<p>Devotees facing difficult planetary periods, shani sade sati, mangal dosh or troubling dashas, come here for graha shanti. Shani Dev presides, and on Saturdays, especially Shani Amavasya, lakhs arrive to offer oil and til, bathe at the sangam and pray for relief. The temple joins astrology to devotion in the most direct way possible.</p>

<h2>What to Experience</h2>
<h3>Shani Amavasya</h3>
<p>The temple's greatest gathering, when the confluence fills with lamps and the air with the scent of sesame oil.</p>
<h3>Graha shanti rituals</h3>
<p>Pandits here perform pujas for each graha; devotees often combine darshan with a Navagraha havan.</p>
HTML
		),

		array(
			'slug'    => 'chausath-yogini-temple-ujjain',
			'title'   => 'Chausath Yogini Temple',
			'city'    => 'Ujjain',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'The 64 Yoginis',
			'darshan' => '6:00 AM to 8:00 PM',
			'aarti'   => 'Evening Aarti at sunset',
			'excerpt' => 'A shrine of the sixty-four yoginis in the ancient tantra tradition, each goddess with her own name and power, keeping alive one of the most mysterious currents of Indian devotion.',
			'content' => <<<'HTML'
<p>The worship of the sixty-four yoginis, powerful goddess forms of the tantra tradition, once spread across the whole of central India. Ujjain's Chausath Yogini temple keeps this rare and mysterious stream of devotion flowing in the city of Mahakal.</p>

<h2>History of the Temple</h2>
<p>Yogini temples flourished in the early medieval centuries, usually built in circular open courts under the sky. Ujjain, as a great seat of Shakta and tantra practice, naturally held the yoginis close, and this temple continues traditions whose roots are older than written records.</p>

<h2>Significance of the Temple</h2>
<p>Each of the sixty-four yoginis carries her own name, mount and power, together representing the complete circle of the Devi's energies. Devotees seeking courage, protection from negativity and success in difficult undertakings pray here, and practitioners of the goddess traditions regard darshan of the full circle as especially potent during Navratri.</p>

<h2>What to Experience</h2>
<h3>Navratri nights</h3>
<p>The temple glows with lamps and the recitation of the Devi's names during both Navratris of the year.</p>
<h3>The circle of the goddesses</h3>
<p>Walk the full circle slowly, reading the yoginis' names; the completeness of the circuit is itself the blessing.</p>
HTML
		),

		array(
			'slug'    => 'patalpuri-temple-prayagraj',
			'title'   => 'Patalpuri Temple',
			'city'    => 'Prayagraj',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Akshayavat and underground shrines',
			'darshan' => '7:00 AM to 6:00 PM',
			'aarti'   => 'As per fort visiting hours',
			'excerpt' => 'An underground temple within the Allahabad Fort sheltering the Akshayavat, the immortal banyan tree said to endure even the dissolution of the world.',
			'content' => <<<'HTML'
<p>Beneath the massive walls of the Allahabad Fort, close to the Sangam where the Ganga and Yamuna meet, lies Patalpuri, one of India's rarest temples: an ancient underground shrine sheltering the Akshayavat, the indestructible banyan.</p>

<h2>History of the Temple</h2>
<p>Patalpuri is mentioned by pilgrims and travellers across many centuries, including the Chinese monk Xuanzang in the seventh century. When the fort was built above it in the Mughal era, the temple survived below, and pilgrims have descended its steps ever since.</p>

<h2>Significance of the Temple</h2>
<p>Scripture calls the Akshayavat imperishable: when the floodwaters of pralaya dissolve the world, this tree alone remains, and upon its leaf the infant Krishna floats. To touch its ancient trunk at the heart of Prayag, the king of tirthas, is considered a completion of the Sangam pilgrimage. The underground corridor holds shrines of many devas gathered in the earth's quiet.</p>

<h2>What to Experience</h2>
<h3>The descent</h3>
<p>Steps lead from daylight into the cool underground hall, a passage that feels like entering another yuga.</p>
<h3>Sangam nearby</h3>
<p>Combine darshan with a boat ride to the confluence, especially during Magh Mela and Kumbh.</p>
HTML
		),

		array(
			'slug'    => 'kashi-vishwanath-temple-varanasi',
			'title'   => 'Kashi Vishwanath Temple',
			'city'    => 'Varanasi',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Lord Shiva (Vishwanath Jyotirlinga)',
			'darshan' => '4:00 AM to 11:00 PM',
			'aarti'   => 'Mangala Aarti 3:00 AM, Sapta Rishi Aarti 7:00 PM',
			'excerpt' => 'The Jyotirlinga of Kashi, lord of the universe, at the heart of the world\'s oldest living city, now joined to the Ganga by the grand Vishwanath corridor.',
			'content' => <<<'HTML'
<p>Kashi Vishwanath is not one temple among many; for countless Hindus it is the center of the sacred world. Here in Varanasi, the city older than memory, Lord Shiva dwells as Vishwanath, the lord of all, in one of the twelve Jyotirlingas.</p>

<h2>History of the Temple</h2>
<p>The shrine has been destroyed and rebuilt through the centuries, and the present golden-spired temple was raised in 1780 by Ahilyabai Holkar of Indore, with the gold plating gifted by Maharaja Ranjit Singh. The newly built Kashi Vishwanath corridor now connects the sanctum directly to the ghats of the Ganga.</p>

<h2>Significance of the Temple</h2>
<p>Scripture promises that Shiva himself whispers the taraka mantra to those who leave their body in Kashi, carrying them across the ocean of samsara. Darshan of Vishwanath with a bath in the Ganga is counted among the most purifying acts a devotee can perform, and pujas performed here, from Rudrabhishek to Mahamrityunjaya jaap, carry the weight of the tirtha itself.</p>

<h2>What to Experience</h2>
<h3>Mangala Aarti before dawn</h3>
<p>The first aarti of the day, in the hush before the city wakes, is Kashi at its most intimate.</p>
<h3>The corridor and the ghats</h3>
<p>Walk from the sanctum to the river through the new corridor, then stay for the evening Ganga Aarti at Dashashwamedh.</p>
HTML
		),

		array(
			'slug'    => 'mahakaleshwar-jyotirlinga-ujjain',
			'title'   => 'Mahakaleshwar Jyotirlinga',
			'city'    => 'Ujjain',
			'state'   => 'Madhya Pradesh',
			'deity'   => 'Lord Shiva (Mahakal)',
			'darshan' => '4:00 AM to 11:00 PM',
			'aarti'   => 'Bhasma Aarti 4:00 AM (advance booking required)',
			'excerpt' => 'The south-facing Jyotirlinga of Ujjain, lord of time and death, whose pre-dawn Bhasma Aarti with sacred ash is among the most extraordinary rituals in all of India.',
			'content' => <<<'HTML'
<p>Mahakal of Ujjain is the lord of time itself. Among the twelve Jyotirlingas, only Mahakaleshwar faces south, the direction of death, declaring that even death is under his rule. The city and the temple have been inseparable for thousands of years.</p>

<h2>History of the Temple</h2>
<p>Ancient texts sing of Mahakal's temple in the golden age of Ujjain, the seat of King Vikramaditya. After destruction in the medieval period, the present temple was rebuilt in the eighteenth century under the Marathas, and the vast new Mahakal Lok corridor now surrounds it with sculpted grandeur.</p>

<h2>Significance of the Temple</h2>
<p>The temple's signature ritual is the Bhasma Aarti before dawn, when the lingam is adorned with sacred ash to the thunder of drums and chanting, a reminder that all things end in ash and all ash rests on Shiva. Devotees book this darshan months ahead. Mahakal is also the deity of protection from untimely death, and the Mahamrityunjaya jaap performed here is sought by families across the world.</p>

<h2>What to Experience</h2>
<h3>Bhasma Aarti</h3>
<p>Reserve well in advance; witnessing it once is said to change a devotee's relationship with time forever.</p>
<h3>Mahakal Lok</h3>
<p>The new corridor's massive sculpted panels tell the Shiva Purana in stone and light.</p>
HTML
		),

		array(
			'slug'    => 'shri-ram-janmabhoomi-mandir-ayodhya',
			'title'   => 'Shri Ram Janmabhoomi Mandir',
			'city'    => 'Ayodhya',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Shri Ram Lalla',
			'darshan' => '6:30 AM to 9:30 PM',
			'aarti'   => 'Mangala Aarti 4:00 AM, Shringar Aarti 6:15 AM, Sandhya Aarti 7:00 PM',
			'excerpt' => 'The grand new temple at the birthplace of Shri Ram in Ayodhya, consecrated in 2024, built in classical Nagara style as the fulfilment of centuries of devotion.',
			'content' => <<<'HTML'
<p>At the janmabhoomi, the birthplace of Shri Ram in Ayodhya, now stands the temple that generations only dreamed of. Consecrated in January 2024 with the pran pratishtha of Ram Lalla, the mandir has become the most visited new pilgrimage destination in India.</p>

<h2>History of the Temple</h2>
<p>The site's history spans centuries of devotion and struggle. The present temple, built in the classical Nagara style entirely of carved sandstone without structural steel, was raised by the Shri Ram Janmabhoomi Teerth Kshetra Trust, with artisans carving pillar after pillar in workshops across India before assembly in Ayodhya.</p>

<h2>Significance of the Temple</h2>
<p>The murti of Ram Lalla, the child Ram, carved in dark shaligram-toned stone, has captured the hearts of devotees worldwide. On Ram Navami, the sun's rays are engineered to fall directly on the deity's forehead in a surya tilak. For pilgrims, darshan here joins naturally with Hanuman Garhi, Kanak Bhavan and the sarayu aarti in one unforgettable yatra.</p>

<h2>What to Experience</h2>
<h3>Darshan of Ram Lalla</h3>
<p>The gentle smile of the child deity is the image devotees carry home; mornings offer the calmest queues.</p>
<h3>Saryu Aarti at sunset</h3>
<p>End the day at the river with lamps floating downstream, as Ayodhya has done for ages.</p>
HTML
		),

		array(
			'slug'    => 'mansa-devi-temple-haridwar',
			'title'   => 'Mansa Devi Temple',
			'city'    => 'Haridwar',
			'state'   => 'Uttarakhand',
			'deity'   => 'Mata Mansa Devi',
			'darshan' => '5:00 AM to 9:00 PM',
			'aarti'   => 'Morning Aarti 5:30 AM, Evening Aarti 8:00 PM',
			'excerpt' => 'The wish-fulfilling goddess on Bilwa Parvat above Haridwar, reached by ropeway or forest path, where devotees tie a sacred thread and return to untie it when the wish comes true.',
			'content' => <<<'HTML'
<p>High on Bilwa Parvat, overlooking Haridwar and the silver ribbon of the Ganga, sits Mata Mansa Devi, the goddess born of the mind of Rishi Kashyap, worshipped for centuries as the fulfiller of heartfelt wishes.</p>

<h2>History of the Temple</h2>
<p>The temple is counted among the Siddh Peeths of Uttarakhand, forming a sacred triangle with Chandi Devi and Maya Devi. Pilgrims have climbed the hill path for generations; today a ropeway carries devotees up in minutes, with the Himalayan foothills unfolding below.</p>

<h2>Significance of the Temple</h2>
<p>Devotees tie a thread to the sacred tree in the temple courtyard while making their manokamna, their heart's wish. When the wish is fulfilled, they return to untie a thread, completing the circle of prayer and gratitude. Darshan of Mansa Devi, joined with a dip at Har Ki Pauri, is the classic Haridwar pilgrimage.</p>

<h2>What to Experience</h2>
<h3>The ropeway ascent</h3>
<p>The view of the Ganga curving through Haridwar is worth the trip by itself.</p>
<h3>Har Ki Pauri below</h3>
<p>Descend in time for the evening Ganga Aarti, when the river blazes with a thousand lamps.</p>
HTML
		),

		array(
			'slug'    => 'neelkanth-mahadev-temple-rishikesh',
			'title'   => 'Neelkanth Mahadev Temple',
			'city'    => 'Rishikesh',
			'state'   => 'Uttarakhand',
			'deity'   => 'Lord Shiva as Neelkanth',
			'darshan' => '5:00 AM to 6:00 PM',
			'aarti'   => 'Morning and evening aarti daily',
			'excerpt' => 'Deep in the forested hills above Rishikesh stands the shrine of the blue-throated Shiva, marking the spot where he drank the poison of the ocean to save all creation.',
			'content' => <<<'HTML'
<p>When the devas and asuras churned the cosmic ocean, the first thing to surface was halahala, a poison strong enough to end creation. Shiva drank it and held it in his throat, which turned forever blue. In the forested hills above Rishikesh, the Neelkanth Mahadev temple marks the sacred spot where tradition says he sat in meditation as the poison cooled.</p>

<h2>History of the Temple</h2>
<p>Surrounded by the valleys of the Manikoot, Brahmakoot and Vishnukoot hills, the shrine has drawn sadhus and pilgrims for centuries. The drive or trek from Ram Jhula through dense forest is part of the pilgrimage itself.</p>

<h2>Significance of the Temple</h2>
<p>Neelkanth embodies the deepest promise of Shiva: he accepts the world's poison so that others may live. Devotees offer bael leaves, water and milk to the shivling, and the temple overflows during Sawan and Shivratri when kanwariyas carry Ganga water up the hill on foot.</p>

<h2>What to Experience</h2>
<h3>The forest road</h3>
<p>Langurs, birdsong and glimpses of the Ganga far below make the journey unforgettable.</p>
<h3>Shivratri in the hills</h3>
<p>The night of Shiva here, with bhajans echoing across the valley, is celebrated with mountain simplicity.</p>
HTML
		),

		array(
			'slug'    => 'gorakhnath-temple-gorakhpur',
			'title'   => 'Gorakhnath Temple',
			'city'    => 'Gorakhpur',
			'state'   => 'Uttar Pradesh',
			'deity'   => 'Guru Gorakhnath',
			'darshan' => '4:00 AM to 9:00 PM',
			'aarti'   => 'Morning Aarti 5:00 AM, Evening Aarti 7:30 PM',
			'excerpt' => 'The great seat of the Nath yogi tradition and the temple that gave Gorakhpur its name, famous for its month-long Khichdi Mela beginning on Makar Sankranti.',
			'content' => <<<'HTML'
<p>The city of Gorakhpur takes its very name from this temple, the principal seat of Guru Gorakhnath, the master yogi of the Nath tradition whose teachings on hatha yoga shaped spiritual practice across India and beyond.</p>

<h2>History of the Temple</h2>
<p>Guru Gorakhnath is honoured as the foremost disciple of Matsyendranath and the systematiser of the Nath sampradaya. The temple complex has been the tradition's headquarters for centuries, its mahants guiding an unbroken lineage of yogis.</p>

<h2>Significance of the Temple</h2>
<p>The temple's most beloved festival is the Khichdi Mela, which begins on Makar Sankranti and continues for a month. Lakhs of devotees offer khichdi, rice and lentils cooked together, to Baba Gorakhnath, a tradition said to have begun when the guru blessed a humble household's simple food above royal feasts. The sprawling complex, with its lake, shrines and gaushala, is a city of devotion within the city.</p>

<h2>What to Experience</h2>
<h3>Khichdi Mela</h3>
<p>One of eastern India's great fairs, where the offering itself feeds thousands daily.</p>
<h3>The Nath tradition up close</h3>
<p>The temple museum and shrines introduce the yogic lineage that carried hatha yoga to the world.</p>
HTML
		),

	);
}
