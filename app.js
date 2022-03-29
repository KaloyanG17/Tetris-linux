document.addEventListener('DOMContentLoaded', () => {
    const grid = document.querySelector('.tetris-bg')
    let squares = Array.from(document.querySelectorAll('.tetris-bg div'))
    const scoreDisplay = document.querySelector('#score')
    const startBtn = document.querySelector('#start-button')
    const width = 10
    let timerId
    let score = 0
    let gameOverFlag = false
    const colors = ['#005B9D','#EE2532','#4EB748','#F79622','#91298C']

    var audio = new Audio('tetris.mp3');
    audio.autoplay = true
    const muteBtn = document.querySelector('#mute-button')
    let audioPlayFlag = true

    //Mute and Unmute Button
    muteBtn.addEventListener('click', () => {
        if(audioPlayFlag == true){
            audio.pause()
            audioPlayFlag = false
        } else {
            audio.play()
            audioPlayFlag = true
        }
    })

    // Block Shapes
    const lShape = [
        [1, width+1, width*2+1, width*2+2],
        [1, 2, 3, width+1],
        [1, 2, width+2, width*2+2],
        [3,width+1 ,width+2, width+3]
    ]
    const zShape = [
        [0,width,width+1,width*2+1],
        [width+1, width+2,width*2,width*2+1],
        [0,width,width+1,width*2+1],
        [width+1, width+2,width*2,width*2+1]
    ]
    const tShape = [
        [1,width,width+1,width+2],
        [1,width+1,width+2,width*2+1],
        [width,width+1,width+2,width*2+1],
        [1,width,width+1,width*2+1]
    ]
    const oShape = [
        [0,1,width,width+1],
        [0,1,width,width+1],
        [0,1,width,width+1],
        [0,1,width,width+1]
    ]
    const iShape = [
        [1,width+1,width*2+1,width*3+1],
        [width,width+1,width+2,width+3],
        [1,width+1,width*2+1,width*3+1],
        [width,width+1,width+2,width+3]
    ]

    const theShapes = [lShape , zShape , tShape , oShape , iShape]

    let currentPosition = 4
    let currentRotation = 0

    //randomly select a shape and its first rotation
    let random = Math.floor(Math.random()*theShapes.length)
    let current = theShapes[random][currentRotation]

    //draw the shape
    function draw() {
        current.forEach(index => {
        squares[currentPosition + index].classList.add('shapes')
        squares[currentPosition + index].style.backgroundColor = colors[random]
        })
    }

    //undraw the shape
    function undraw() {
        current.forEach(index => {
        squares[currentPosition + index].classList.remove('shapes')
        squares[currentPosition + index].style.backgroundColor = ''

        })
    }

    //assign functions to keyCodes
    function control(e) {
        if(gameOverFlag == true){
            return;
        }else{
            if(e.keyCode === 37) {
            moveLeft()
            } else if (e.keyCode === 38) {
            rotate()
            } else if (e.keyCode === 39) {
            moveRight()
            } else if (e.keyCode === 40) {
            moveDown()
            }
        }
    }

    document.addEventListener('keyup', control)

    //move down function
    function moveDown() {
        undraw()
        currentPosition += width
        draw()
        freeze()
    }

    //freeze function
    function freeze() {
        if(current.some(index => squares[currentPosition + index + width].classList.contains('taken'))) {
        current.forEach(index => squares[currentPosition + index].classList.add('taken'))
        //start a new shape falling
        random = nextRandom
        nextRandom = Math.floor(Math.random() * theShapes.length)
        current = theShapes[random][currentRotation]
        currentPosition = 4
        audio.play()
        draw()
        addScore()
        gameOver()
        }
    }

    //move the shape left, unless is at the edge or there is a blockage
    function moveLeft() {
        undraw()
        const isAtLeftEdge = current.some(index => (currentPosition + index) % width === 0)
        if(!isAtLeftEdge) currentPosition -=1
        if(current.some(index => squares[currentPosition + index].classList.contains('taken'))) {
        currentPosition +=1
        }
        draw()
    }

    //move the shape right, unless is at the edge or there is a blockage
    function moveRight() {
        undraw()
        const isAtRightEdge = current.some(index => (currentPosition + index) % width === width -1)
        if(!isAtRightEdge) currentPosition +=1
        if(current.some(index => squares[currentPosition + index].classList.contains('taken'))) {
        currentPosition -=1
        }
        draw()
    }

    
    ///Check when rotating near edges
    function isAtRight() {
        return current.some(index=> (currentPosition + index + 1) % width === 0)  
    }
    
    function isAtLeft() {
        return current.some(index=> (currentPosition + index) % width === 0)
    }
    
    function checkRotatedPosition(P){
        P = P || currentPosition    
        if ((P+1) % width < 4) {     
            if (isAtRight()){            
                currentPosition += 1  
                checkRotatedPosition(P) 
            }
        }
        else if (P % width > 5) {
            if (isAtLeft()){
                currentPosition -= 1
            checkRotatedPosition(P)
            }
        }
    }
    
    //rotate the shape
    function rotate() {
        undraw()
        currentRotation ++
        if(currentRotation === current.length) { //if the current rotation gets to 4, make it go back to 0
        currentRotation = 0
        }
        current = theShapes[random][currentRotation]
        checkRotatedPosition()
        draw()
    }

    //add functionality to the button
    startBtn.addEventListener('click', () => {
        audio.play();
        if (timerId) {
            clearInterval(timerId)
            timerId = null
        } else {
            draw()
            timerId = setInterval(moveDown, 1000)
            nextRandom = Math.floor(Math.random()*theShapes.length)
        }
    })

    //add score
    function addScore() {
        for (let i = 0; i < 199; i +=width) {
            const row = [i, i+1, i+2, i+3, i+4, i+5, i+6, i+7, i+8, i+9]

            if(row.every(index => squares[index].classList.contains('taken'))) {
                score +=1
                scoreDisplay.innerHTML = score
                row.forEach(index => {
                squares[index].classList.remove('taken')
                squares[index].classList.remove('shapes')
                squares[index].style.backgroundColor = ''
                })
                const squaresRemoved = squares.splice(i, width)
                squares = squaresRemoved.concat(squares)
                squares.forEach(cell => grid.appendChild(cell))
            }
        }
    }

    //game over
    function gameOver() {
        if(current.some(index => squares[currentPosition + index].classList.contains('taken'))) {
            scoreDisplay.innerHTML = score + "<br>Game Over"
            clearInterval(timerId)
            gameOverFlag = true;
            var httpr=new XMLHttpRequest();
            httpr.open("POST","leaderboard.php",true);
            httpr.setRequestHeader("content-type","application/x-www-form-urlencoded");
            httpr.onreadystatechange=function(){
                if(httpr.status==200){
                    document.getElementById("response").innerHTML="Inserted";
                }else{
                    console.log("Error");
                }
            }
            httpr.send("score="+score);
        }
    }

    

})