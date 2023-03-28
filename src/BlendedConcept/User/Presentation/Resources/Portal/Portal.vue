<template>
    <FrontendLayout>
        <!-- slider -->
        <div class="bg-no-repeat grid bg-cover" style="background-image:url('images/portalbanner.png')">

          <div class="flex flex-col w-80 p-14 z-10">
          <h3 class="text-h4 font-fredoka text-secondary leading-[44px] align-top uppercase whitespace-nowrap">50% off ALL ITEMS</h3>
          <p class="font-fredoka font-[400] ">
            <span class="text-primary text-[56px] tracking-[8.5%]">Special</span> <span class="text-[108px] text-primary leading-[114px] whitespace-wrap">DISCOUNT</span>

          </p>
          <Button label="View Detail >>" class="w-[152px] text-[16px] whitespace-nowrap h-[48px] leading-[24px] bg-secondary hover:bg-yellow-900 text-primary font-bold"/>
          </div>

        </div>
        <!-- story books  -->
        <h3
            class="px-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top"
        >
            Favorite Books
        </h3>
        <div
            class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 justify-items-center py-4 px-8 gap-1"
        >
            <Image src="images/sample1.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
        </div>
        <Divider type="solid" />
        <h3
            class="px-10 text-h3 leading-9 text-primary font-fredoka font-medium align-top"
        >
            Recommended Books
        </h3>
        <div
            class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-7 justify-items-center py-4 px-8 gap-1"
        >
            <Image src="images/sample1.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
            <Image src="images/sample2.png" class="px-2" alt="Image" />
        </div>

        <!-- storybook how it work -->
        <div
            class="card grid p-7 grid-cols-1 lg:grid-cols-2 gap-4 mt-10"
            style="background-image: url('images/howitwork.png')"
        >
            <div class="text-left px-5">
                <h5 class=" text-[14px] align-top text-left leading-6 font-semibold text-primary">
                    How it works
                </h5>
                <h1
                    class="text-[48px] leading-[58px] text-primary font-fredoka mt-2"
                >
                    Welcome to our wonderful <br />
                    world of storybooks!
                </h1>
                <div class="mt-5">
                    <Button label="Learn More" />
                </div>
            </div>
            <div class="text-center px-5">
                <!-- timeline design -->
                <div class="flex flex-col gap-20 space-y-8 pl-6">
                    <div class="flex items-center">
                        <PackageIcon />
                        <div class="line"></div>
                        <div class="pl-4 text-justify">
                            <p
                                class="font-bold text-left text-h5 text-primary font-fredoka"
                            >
                                Enchanting Adventures
                            </p>
                            <p
                                class="text-primary text-body leading-6 font-fredoka"
                            >
                                Our collection of captivating tales and
                                enchanting adventures will transport you to
                                different worlds and ignite your imagination.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <PackageIcon />
                        <div class="line"></div>
                        <div class="pl-4 text-justify">
                            <p
                                class="font-bold text-left text-h5 text-primary font-fredoka"
                            >
                                Carefully Curated
                            </p>
                            <p
                                class="text-primary text-body leading-6 font-fredoka"
                            >
                                Our books are carefully curated to provide a
                                wide range of options for children of all ages.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <PackageIcon />
                        <div class="line"></div>
                        <div class="pl-4 text-justify">
                            <p
                                class="font-bold text-left text-h5 text-primary font-fredoka"
                            >
                                Delightful Picture Books
                            </p>
                            <p
                                class="text-primary text-body leading-6 font-fredoka"
                            >
                                From delightful picture books for the littlest
                                ones to gripping chapter books for older kids
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <PackageIcon />
                        <!-- <div class="line"></div> -->
                        <div class="pl-4 text-justify">
                            <p
                                class="font-bold text-left text-h5 text-primary font-fredoka"
                            >
                                Joyful Experience
                            </p>
                            <p
                                class="text-primary text-body leading-6 font-fredoka"
                            >
                                We believe that reading should be a joyful
                                experience, and our stories are crafted with
                                that in mind.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- timelin design end -->
            </div>
        </div>

        <!-- Pricing Plan -->
        <div class="card px-5 text-primary p-7">
            <h1 class="text-4xl mt-2  text-[48px] mb-4  font-[500] text-primary  pl-10">Pricing Plan</h1>
            <p class="mt-2 text-primary font-[400] text-normal  leading-[150%] text-body pl-10">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
            </p>

            <div class="card grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6 justify-items-center gap-5 mt-10">
                <Card
                    class="col-span-2 border-2 text-primary border-indigo-500/50"
                    style="width: 25em"
                >
                    <template #title> Basic Plan </template>
                    <template #subtitle>
                        <span class="text-primary font-bold">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </span>
                    </template>
                    <template #content>
                        <Divider type="solid" />
                        <h2 class="text-4xl font-bold font-fredoka">$19 /mo</h2>
                        <p class="mt-2 text-body font-bold">or $199 yearly</p>
                        <div class="mt-5">
                            <Button label="Get Starterd" class="w-full" />
                        </div>
                        <Divider type="solid"/>
                    </template>
                    <template #footer>
                        <p>
                            <span class="material-symbols-outlined px-2"> done</span>
                            Feature Text will go here
                        </p>
                        <p>
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                        <p>
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                    </template>
                </Card>
                <Card
                    class="col-span-2 border-2 text-primary border-indigo-500/50"
                    style="width: 25em"
                >
                    <template #title> Business Plan </template>
                    <template #subtitle>
                       <span class="text-primary font-bold">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </span>
                    </template>
                    <template #content>
                        <Divider type="solid" />
                        <h2 class="text-4xl font-bold font-fredoka">$29 /mo</h2>
                        <p class="mt-2 text-body font-bold">or $199 yearly</p>
                        <div class="mt-5">
                            <Button label="Get Starterd" class="w-full"/>
                        </div>
                        <Divider type="solid" />
                    </template>
                    <template #footer>
                        <p>
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                        <p>
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                        <p>
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                    </template>
                </Card>
                <Card
                    class="col-span-2 border-2 text-primary border-indigo-500/50"
                    style="width: 25em"
                >
                    <template #title> Enterprise Plan </template>
                    <template #subtitle>
                    <span class="text-primary font-bold">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        </span>
                    </template>
                    <template #content>
                        <Divider type="solid" />
                        <h2 class="text-4xl font-bold font-fredoka">$49 /mo</h2>
                        <p class="mt-2 text-body font-bold">or $199 yearly</p>
                        <div class="mt-5">
                            <Button label="Get Starterd" class="w-full"/>
                        </div>
                        <Divider type="solid" />
                    </template>
                    <template #footer>
                        <p class="text-primary font-fredoka">
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >
                            <span class="font-bold">
                            Text will go here
                            </span>
                        </p>
                        <p class="text-primary font-bold font-fredoka">
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                        <p class="text-primary font-bold font-fredoka">
                            <span class="material-symbols-outlined px-2"
                                >done</span
                            >Feature Text will go here
                        </p>
                    </template>
                </Card>
            </div>
        </div>

        <!-- visitor invite -->
        <div
            class="card mt-10 py-10 text-center bg-cover"
            style="background-image: url('images/banner.png')"
        >
            <h1 class="text-[48px] text-primary font-bold">
                Call to action that invites visitor <br />
                to try the product for free
            </h1>
            <p class="mt-4 font-[14px] leading-[150%] text-primary">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit.
            </p>
            <div class="flex justify-center mt-10">
                <InputText placeholder="Enter" />
                <div class="ml-2">
                    <Button label="Try it for free"/>
                </div>
            </div>
            <p class="mt-3 text-sm text-primary">
                By clicking <a href="Sign Up">Sign Up</a> you're confirming that
                you agree with our Terms and Conditions.
            </p>

            <h5 class="mt-10 text-xl">
                Trusted by the world's best countries [social proof to build
                credibility]
            </h5>
            <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-6 gap-4  mt-10 items-center justify-items-center px-5">
                <Image src="images/logosample1.png" class="px-5" alt="Image" />
                <Image src="images/logosample2.png" class="px-5" alt="Image" />
                <Image src="images/logosample1.png" class="px-5" alt="Image" />
                <Image src="images/logosample2.png" class="px-5" alt="Image" />
                <Image src="images/logosample1.png" class="px-5" alt="Image" />
                <Image src="images/logosample2.png" class="px-5" alt="Image" />
            </div>
        </div>

        <!-- FAQ -->
        <div
            class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-6 mt-10 mb-5 px-5"
        >
            <div class="col-span-3 text-left px-5">
                <h1 class="text-4xl mt-2 text-primary font-bold font-worksans">
                    Frequently asked <br />
                    questions
                </h1>
                <p
                    class="mt-4 text-primary font-worksans leading-7 text-justify font-bold text-body"
                >
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Corrupti, accusamus a quibusdam <br />
                    atque natus alias iste reiciendis odio itaque corporis est
                    ullam, illum excepturi laborum praesentium rerum
                    <br />
                    officia culpa magnam!
                </p>
                <div class="mt-5 sm:mb-4">
                    <Button label="Contact Us" />
                </div>
            </div>
            <div class="col-span-3 text-center px-5">
                <Accordion :multiple="true">
                    <AccordionTab header="Question text goes there">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis
                            nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in voluptate velit esse cillum dolore
                            eu fugiat nulla pariatur. Excepteur sint occaecat
                            cupidatat non proident, sunt in culpa qui officia
                            deserunt mollit anim id est laborum.
                        </p>
                    </AccordionTab>
                    <AccordionTab header="Question text goes there">
                        <p>
                            Sed ut perspiciatis unde omnis iste natus error sit
                            voluptatem accusantium doloremque laudantium, totam
                            rem aperiam, eaque ipsa quae ab illo inventore
                            veritatis et quasi architecto beatae vitae dicta
                            sunt explicabo. Nemo enim ipsam voluptatem quia
                            voluptas sit aspernatur aut odit aut fugit, sed quia
                            consequuntur magni dolores eos qui ratione
                            voluptatem sequi nesciunt. Consectetur, adipisci
                            velit, sed quia non numquam eius modi.
                        </p>
                    </AccordionTab>
                    <AccordionTab header="Question text goes here">
                        <p>
                            At vero eos et accusamus et iusto odio dignissimos
                            ducimus qui blanditiis praesentium voluptatum
                            deleniti atque corrupti quos dolores et quas
                            molestias excepturi sint occaecati cupiditate non
                            provident, similique sunt in culpa qui officia
                            deserunt mollitia animi, id est laborum et dolorum
                            fuga. Et harum quidem rerum facilis est et expedita
                            distinctio. Nam libero tempore, cum soluta nobis est
                            eligendi optio cumque nihil impedit quo minus.
                        </p>
                    </AccordionTab>
                    <AccordionTab header="Question text goes here">
                        <p>
                            At vero eos et accusamus et iusto odio dignissimos
                            ducimus qui blanditiis praesentium voluptatum
                            deleniti atque corrupti quos dolores et quas
                            molestias excepturi sint occaecati cupiditate non
                            provident, similique sunt in culpa qui officia
                            deserunt mollitia animi, id est laborum et dolorum
                            fuga. Et harum quidem rerum facilis est et expedita
                            distinctio. Nam libero tempore, cum soluta nobis est
                            eligendi optio cumque nihil impedit quo minus.
                        </p>
                    </AccordionTab>
                    <AccordionTab header="Question text goes here">
                        <p>
                            At vero eos et accusamus et iusto odio dignissimos
                            ducimus qui blanditiis praesentium voluptatum
                            deleniti atque corrupti quos dolores et quas
                            molestias excepturi sint occaecati cupiditate non
                            provident, similique sunt in culpa qui officia
                            deserunt mollitia animi, id est laborum et dolorum
                            fuga. Et harum quidem rerum facilis est et expedita
                            distinctio. Nam libero tempore, cum soluta nobis est
                            eligendi optio cumque nihil impedit quo minus.
                        </p>
                    </AccordionTab>
                </Accordion>
            </div>
        </div>
        <footer
            class="grid grid-cols-6 lg:grid-cols-12 md:grid-cols-4 justify-items-center items-center p-4"
        >
            <div class="pl-10 col-span-6 font-bold mt-5">
                <h1 class="text-primary text-h4 font-bold">Logo</h1>
                <p class="text-primary font-fredoka">
                    Join our newsletter to stay up to date on features and
                    releases.
                </p>
                <div class="flex gap-3">
                    <InputText type="text" v-model="value" />
                    <Button label="Submit" />
                </div>
                <p class="text-primary font-fredoka text-body mt-5 mb-5">
                    By subscribing you agree to with our Privacy Policy and
                    provide consent to receive updates from our company.
                </p>
            </div>
            <div class="col-span-2">
                <h4 class="text-primary text-body font-bold pb-3">column one</h4>
                <ul>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items one</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item two</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items three</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item four</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item five</li>
                </ul>
            </div>
            <div class="col-span-2">
                <h4 class="text-primary text-body font-bold pb-3">column one</h4>
                <ul>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items one</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item two</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items three</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item four</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item five</li>
                </ul>
            </div>
            <div class="col-span-2">
                <h4 class="text-primary text-body font-bold pb-3">column one</h4>
                <ul>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items one</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item two</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">items three</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item four</li>
                    <li class="text-primary font-fredoka text-caption font-bold pb-2">item five</li>
                </ul>
            </div>
        </footer>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from "@Layouts/Portal/FrontendLayout.vue";
import PackageIcon from "@Composables/icons/PackageIcon.vue";
// import portaBanner from "images/portalbanner.png";
</script>

<style>
.line {
    position: absolute;
    margin-top: 10%;
    margin-left: 1.2%;
    width: 1px;
    height: 100px;
    background-color: #001a8f;
}

@media screen and (max-width:460px) {
   .line
   {
     margin-top: 40%;
     margin-left: 4%;
   }
}

</style>
