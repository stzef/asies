<div style="padding: 25px; background-color: #eee; ">
	<img src="https://lh3.googleusercontent.com/1xgvyGkRKrGqgJNO-3Mo_u47hgkaZmPkQ8Kuda9SVlQY8oUUfVbq7uf4rTlBkwHOC8b1I2ck1vAmkrm31PkfuE0pG8x0haADuNWQgU5gPa7Sg5aNHWGAqDXg9RFHUwdIzCt8NIxxWMP_zb5GP-M7VDRYO8pO2N7QYpq88fXmGsme73_hwllChJawGONmCCwuC6b2q9bOYkoJZTB3vLx8OA-gemHZE5J6viwNQ8smZgi2Vvlnfzk9t_0aOCmxMr6ym-C59hntMtfTxITpmIc1IKv9Q7LPlSiA-JEnzrCnBYDe6kUTuV6xiQI6T0sdS5Um0up7oB1P4TopzRMPMPW7-ewEUk6Q6Ey9lQn2LhdamRRrpP2_zsE6gkvFiqughvSUcRyc3QEgtPyTN7-IIte7Gkhtnj2MWR6eHXfJk1dwpJ9yiBpSyVYXp5AZq_1Ie5h76idphWkkEkpRzEo0rl_Xb-UK_N9qqmrcC0mP2nN1ajUx5Qvu-ZQDFIBDwWfYkMReWwQErKutmY3Xti8U5tRxT8E0Q0iAj1rAdbbO7hmbhyy-gYScmL_9MdMzbMBUpG2EAJ79lnhESv78i32w71YweKse0viFl5x113Sffvtmst-tV5wl=w976-h261-no" alt="" >
</div>
<div style="background-color: #eee; border-bottom-right-radius:3px;border-bottom-left-radius:3px;">
<table style="font: 14px arial;  border-color: #eaebed;" cellspacing="30">
	<tbody>
		<tr>
			<td width="50%">
					<center>
					<h1 style="font-style: Arial;">Acta de Reunión</h1>
					<img src="https://lh3.googleusercontent.com/OPsiLqmsdU8FP3EXbGUGPmG4Jh5zC7JXp-wMakEiFb_o1abhkTzG7dU1wmWIhpta1e2mE7pY5znroIivsttvSBACxvj-ClvvU0VJkhLUpskS-wTjcbI1JrXH3yrcbUmap98LL3hdSTmlN-VHvZwV6PKpIIkXlIouIvXIYxe0bmYPRTFHgf9bTjBDLa8vK2yixSYUZH4NyWZEO7V5CLdD3ZspkjLam_rnZx7_CHANueyGcJ3hlHn9McxJV2p6VlEt5awvLely1arQXqgG70N5MPI8JlCASz9Pkmi1P2sZmL25s8E0DhE-yxm9lMq6mMBZEE7RO0C6QUhrE_YVYdaYWWu_CxIIz-wuoojuNGZU1BCRstfx-yfVA7Ua2-DYLNJ6gjc6PMliY_9cFQlzg05KRAgieQnDv2EppuAGCbzJtvrlB_0tP4EN5T20roXaK2RXPy6Ibfb7YYRT-_GsSWQs7cDZ_hYPyhjP5yVqkt3dKv4EPnvWjTHWvqqT212EJm1rqjO2d736qG6dL0GLHCA0ljjSQmcETPs0Itlagl7jwftZffRZuot-NIga8hnTNEuijJY5TOPkvbTNmab3vUeXrBwP9o1mvn8OPeBdUgUs9ga3Clm2t3ZQ=w692-h354-no" alt="" style="width: 75%">
					</center>
			</td>
			<td width="50%" style="border-color: #eaebed;">
			    <center><h2>Actividad : {{$actividad->nactividad}}</h2></center>
			    <ul>
						<li style="font-style: normal;font-size: 18px;">Numero Acta: {{$acta->numeroacta}}</li>
						<li style="font-style: normal;font-size: 18px;">Objetivos : {{ $acta->objetivos }}</li>
						<li style="font-style: normal;font-size: 18px;">Fecha Inicial : {{ $acta->fhini }}</li>
						<li style="font-style: normal;font-size: 18px;">Fecha Final : {{ $acta->fhfin }}</li>
				</ul>
				<br>
			    <p>
			    <center><a href="http://controlasies.com.co/" style="background-color: #00afc9; padding: 15px 20px; border-radius: 3px; text-transform: uppercase; color: white; text-decoration: none;" target="_blank"><strong>Ir al sitio</strong></a></center>
			    </p><br>
			</td>
		</tr>
	</tbody>
</table>
</div>


<h1>CONTROL ASIES</h1>
<h2>Acta de Reunión</h2>

<h3>Actividad : {{$actividad->nactividad}}</h3>

<ul>
	<li>Numero Acta: {{$acta->numeroacta}}</li>
	<li>Objetivos : {{ $acta->objetivos }} </li>
	<li>Fecha Inicial : {{ $acta->fhini }} </li>
	<li>Fecha Final : {{ $acta->fhfin }} </li>
</ul>
