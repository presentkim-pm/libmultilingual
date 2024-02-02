<div align="center">
  <a href="https://github.com/presentkim-pm/libmultilingual" target="_blank">
    <img src="https://raw.githubusercontent.com/presentkim-pm/libmultilingual/main/assets/icon.png" alt="Logo" width="80" height="80"/>
  </a>
  <h1>libmultilingual :: GlobalParams</h1>
</div>

## :tada: Overview
This library given `GlobalParams` which manage default translation parameters.  
This global parameter list is used common to all translations.  
This feature was added to make it easier to use line breaks and Minecraft emojis.  
You can also add them through plugins!

<details>
<summary>Default global params list</summary>

|          Param name          | Character  |                                                                  In game                                                                  |
|:----------------------------:|:----------:|:-----------------------------------------------------------------------------------------------------------------------------------------:|
|              n               |    `\n`    |                                                            New line charactor                                                             |
|              br              |    `\n`    |                                                            New line charactor                                                             |
|             tab              |    `\t`    |                                                               Tab charactor                                                               |
|              t               |    `\t`    |                                                               Tab charactor                                                               |
|            xbox-a            | `\u{E000}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-a.png" width="32px">            |
|            xbox-b            | `\u{E001}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-b.png" width="32px">            |
|            xbox-x            | `\u{E002}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-x.png" width="32px">            |
|            xbox-y            | `\u{E003}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-y.png" width="32px">            |
|           xbox-lb            | `\u{E004}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-lb.png" width="32px">            |
|           xbox-rb            | `\u{E005}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-rb.png" width="32px">            |
|           xbox-lt            | `\u{E006}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-lt.png" width="32px">            |
|           xbox-rt            | `\u{E007}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-rt.png" width="32px">            |
|         xbox-select          | `\u{E008}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-select.png" width="32px">          |
|          xbox-start          | `\u{E009}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-start.png" width="32px">          |
|           xbox-ls            | `\u{E00A}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-ls.png" width="32px">            |
|           xbox-rs            | `\u{E00B}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-rs.png" width="32px">            |
|          xbox-d-up           | `\u{E00C}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-d-up.png" width="32px">           |
|         xbox-d-left          | `\u{E00D}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-d-left.png" width="32px">          |
|         xbox-d-down          | `\u{E00E}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-d-down.png" width="32px">          |
|         xbox-d-right         | `\u{E00F}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-d-right.png" width="32px">         |
|        xbox-a-bright         | `\u{E010}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-a-bright.png" width="32px">         |
|        xbox-b-bright         | `\u{E011}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-b-bright.png" width="32px">         |
|        xbox-x-bright         | `\u{E012}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-x-bright.png" width="32px">         |
|        xbox-y-bright         | `\u{E013}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/xbox-y-bright.png" width="32px">         |
|             jump             | `\u{E014}` |             <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/jump.png" width="32px">             |
|            attack            | `\u{E015}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/attack.png" width="32px">            |
|           joystick           | `\u{E016}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/joystick.png" width="32px">           |
|          crosshair           | `\u{E017}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/crosshair.png" width="32px">           |
|           interact           | `\u{E018}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/interact.png" width="32px">           |
|            crouch            | `\u{E019}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/crouch.png" width="32px">            |
|            sprint            | `\u{E01A}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/sprint.png" width="32px">            |
|            fly-up            | `\u{E01B}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-up.png" width="32px">            |
|           fly-down           | `\u{E01C}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-down.png" width="32px">           |
|           dismount           | `\u{E01D}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/dismount.png" width="32px">           |
|             ps-x             | `\u{E020}` |             <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-x.png" width="32px">             |
|             ps-o             | `\u{E021}` |             <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-o.png" width="32px">             |
|          ps-square           | `\u{E022}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-square.png" width="32px">           |
|         ps-triangle          | `\u{E023}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-triangle.png" width="32px">          |
|            ps-l1             | `\u{E024}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-l1.png" width="32px">             |
|            ps-r1             | `\u{E025}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-r1.png" width="32px">             |
|            ps-l2             | `\u{E026}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-l2.png" width="32px">             |
|            ps-r2             | `\u{E027}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-r2.png" width="32px">             |
|          ps-select           | `\u{E028}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-select.png" width="32px">           |
|           ps-start           | `\u{E029}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-start.png" width="32px">           |
|            ps-l3             | `\u{E02A}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-l3.png" width="32px">             |
|            ps-r3             | `\u{E02B}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-r3.png" width="32px">             |
|           ps-d-up            | `\u{E02C}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-d-up.png" width="32px">            |
|          ps-d-left           | `\u{E02D}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-d-left.png" width="32px">           |
|          ps-d-down           | `\u{E02E}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-d-down.png" width="32px">           |
|          ps-d-right          | `\u{E02F}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/ps-d-right.png" width="32px">          |
|          nintendo-a          | `\u{E040}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-a.png" width="32px">          |
|          nintendo-b          | `\u{E041}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-b.png" width="32px">          |
|          nintendo-x          | `\u{E042}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-x.png" width="32px">          |
|          nintendo-y          | `\u{E043}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-y.png" width="32px">          |
|          nintendo-l          | `\u{E044}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-l.png" width="32px">          |
|          nintendo-r          | `\u{E045}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-r.png" width="32px">          |
|         nintendo-zl          | `\u{E046}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-zl.png" width="32px">          |
|         nintendo-zr          | `\u{E047}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-zr.png" width="32px">          |
|        nintendo-minus        | `\u{E048}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-minus.png" width="32px">        |
|        nintendo-plus         | `\u{E049}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-plus.png" width="32px">         |
|         nintendo-ls          | `\u{E04A}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-ls.png" width="32px">          |
|         nintendo-rs          | `\u{E04B}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-rs.png" width="32px">          |
|        nintendo-d-up         | `\u{E04C}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-d-up.png" width="32px">         |
|       nintendo-d-left        | `\u{E04D}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-d-left.png" width="32px">        |
|       nintendo-d-down        | `\u{E04E}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-d-down.png" width="32px">        |
|       nintendo-d-right       | `\u{E04F}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/nintendo-d-right.png" width="32px">       |
|          left-mouse          | `\u{E060}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/left-mouse.png" width="32px">          |
|         right-mouse          | `\u{E061}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/right-mouse.png" width="32px">          |
|         middle-mouse         | `\u{E062}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/middle-mouse.png" width="32px">         |
|            mouse             | `\u{E063}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mouse.png" width="32px">             |
|      forward-arrow-new       | `\u{E065}` |      <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/forward-arrow-new.png" width="32px">       |
|        left-arrow-new        | `\u{E066}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/left-arrow-new.png" width="32px">        |
|        down-arrow-new        | `\u{E067}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/down-arrow-new.png" width="32px">        |
|       right-arrow-new        | `\u{E068}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/right-arrow-new.png" width="32px">        |
|       jump-button-new        | `\u{E069}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/jump-button-new.png" width="32px">        |
|      crouch-button-new       | `\u{E06A}` |      <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/crouch-button-new.png" width="32px">       |
|       inventory-button       | `\u{E06B}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/inventory-button.png" width="32px">       |
|      fly-up-button-new       | `\u{E06C}` |      <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-up-button-new.png" width="32px">       |
|     fly-down-button-new      | `\u{E06D}` |     <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-down-button-new.png" width="32px">      |
|        left-mouse-new        | `\u{E070}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/left-mouse-new.png" width="32px">        |
|       right-mouse-new        | `\u{E071}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/right-mouse-new.png" width="32px">        |
|       middle-mouse-new       | `\u{E072}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/middle-mouse-new.png" width="32px">       |
|          mouse-new           | `\u{E073}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mouse-new.png" width="32px">           |
|      forward-arrow-new       | `\u{E080}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/forward-arrow.png" width="32px">         |
|          left-arrow          | `\u{E081}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/left-arrow.png" width="32px">          |
|          down-arrow          | `\u{E082}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/down-arrow.png" width="32px">          |
|         right-arrow          | `\u{E083}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/right-arrow.png" width="32px">          |
|         jump-button          | `\u{E084}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/jump-button.png" width="32px">          |
|        crouch-button         | `\u{E085}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/crouch-button.png" width="32px">         |
|        fly-up-button         | `\u{E086}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-up-button.png" width="32px">         |
|       fly-down-button        | `\u{E087}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/fly-down-button.png" width="32px">        |
|         craftable-on         | `\u{E0A0}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/craftable-on.png" width="32px">         |
|        craftable-off         | `\u{E0A1}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/craftable-off.png" width="32px">         |
|            mr-lg             | `\u{E0C0}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-lg.png" width="32px">             |
|            mr-rg             | `\u{E0C1}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-rg.png" width="32px">             |
|           mr-menu            | `\u{E0C2}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-menu.png" width="32px">            |
|            mr-ls             | `\u{E0C3}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-ls.png" width="32px">             |
|            mr-rs             | `\u{E0C4}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-rs.png" width="32px">             |
|       mr-left-touchpad       | `\u{E0C5}` |       <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-left-touchpad.png" width="32px">       |
| mr-left-touchpad-horizontal  | `\u{E0C6}` | <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-left-touchpad-horizontal.png" width="32px">  |
|  mr-left-touchpad-vertical   | `\u{E0C7}` |  <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-left-touchpad-vertical.png" width="32px">   |
|      mr-right-touchpad       | `\u{E0C8}` |      <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-right-touchpad.png" width="32px">       |
| mr-right-touchpad-horizontal | `\u{E0C9}` | <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-right-touchpad-horizontal.png" width="32px"> |
|  mr-right-touchpad-vertical  | `\u{E0CA}` |  <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-right-touchpad-vertical.png" width="32px">  |
|            mr-lt             | `\u{E0CB}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-lt.png" width="32px">             |
|            mr-rt             | `\u{E0CC}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-rt.png" width="32px">             |
|          mr-windows          | `\u{E0CD}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/mr-windows.png" width="32px">          |
|          rift-zero           | `\u{E0E0}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-zero.png" width="32px">           |
|            rift-a            | `\u{E0E1}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-a.png" width="32px">            |
|            rift-b            | `\u{E0E2}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-b.png" width="32px">            |
|           rift-lg            | `\u{E0E3}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-lg.png" width="32px">            |
|           rift-rg            | `\u{E0E4}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-rg.png" width="32px">            |
|           rift-ls            | `\u{E0E5}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-ls.png" width="32px">            |
|           rift-rs            | `\u{E0E6}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-rs.png" width="32px">            |
|           rift-lt            | `\u{E0E7}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-lt.png" width="32px">            |
|           rift-rt            | `\u{E0E8}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-rt.png" width="32px">            |
|            rift-x            | `\u{E0E9}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-x.png" width="32px">            |
|            rift-y            | `\u{E0EA}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/rift-y.png" width="32px">            |
|             food             | `\u{E100}` |             <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/food.png" width="32px">             |
|            armour            | `\u{E101}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/armour.png" width="32px">            |
|           minecoin           | `\u{E102}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/minecoin.png" width="32px">           |
|         code-builder         | `\u{E103}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/code-builder.png" width="32px">         |
|   immersive-reader-button    | `\u{E104}` |   <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/immersive-reader-button.png" width="32px">    |
|            token             | `\u{E105}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/token.png" width="32px">             |
|         hollow-star          | `\u{E106}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/hollow-star.png" width="32px">          |
|          solid-star          | `\u{E107}` |          <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/solid-star.png" width="32px">          |
|        wooden-pickaxe        | `\u{E108}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/wooden-pickaxe.png" width="32px">        |
|         wooden-sword         | `\u{E109}` |         <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/wooden-sword.png" width="32px">         |
|        crafting-table        | `\u{E10A}` |        <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/crafting-table.png" width="32px">        |
|           furnace            | `\u{E10B}` |           <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/furnace.png" width="32px">            |
|            heart             | `\u{E10C}` |            <img src="https://github.com/TwistedAsylumMC/bedrock-unicode-characters/raw/master/images/heart.png" width="32px">             |

[See also source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/GlobalParams.php)
</details>

-----
<br/>

## :book: What does provides?  
This class provides the following static methods:
```php
/** @return array<string, string> The list of global translate parameters */
public static function getAll() : array

/**
 * Sets a global translate parameter
 *
 * @param string $paramName The parameter name
 * @param string $contents The parameter's replacement contents
 */
public static function set(string $paramName, string $contents) : void

/**
 * Removes a global translate parameter
 *
 * @param string $paramName The parameter name
 */
public static function remove(string $paramName) : void
```
[See source](https://github.com/presentkim-pm/libmultilingual/blob/main/src/kim/present/libmultilingual/GlobalParams.php)

-----
<br/>

## :book: How to register my custom parameters?
You can always add parameters via the `GlobalParams::register()` static method.
```php
use kim\present\libmultilingual\GlobalParams;

//Example source that set `server-name` parameter
public function onEnable() : void{  
    GlobalParams::set("server-name", $this->getServer()->getName()); 
}
```

Also can update parameters in real time to create dynamic messages.
```php
use kim\present\libmultilingual\GlobalParams;

//Example source that set `player-count` parameter
public function onEnable() : void{  
   $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
       GlobalParams::set("player-count", (string) count($this->getServer()->getOnlinePlayers()));
   }), 1);
}
```   

-----
