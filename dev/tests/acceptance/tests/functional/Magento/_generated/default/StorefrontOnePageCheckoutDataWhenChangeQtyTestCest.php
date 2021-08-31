<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MAGETWO-96960: One page Checkout Customer data when changing Product Qty")
 * @Description("One page Checkout Customer data when changing Product Qty<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontOnePageCheckoutDataWhenChangeQtyTest.xml<br>")
 * @TestCaseId("MAGETWO-96960")
 * @group checkout
 */
class StorefrontOnePageCheckoutDataWhenChangeQtyTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create a product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$runCronIndexer = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontOnePageCheckoutDataWhenChangeQtyTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart and checkout");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->fillField("input[id*=customer-email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: enterEmail
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstName
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastName
		$I->fillField("input[name='street[0]']", "7700 W Parmer Ln"); // stepKey: enterStreet
		$I->fillField("input[name=city]", "Austin"); // stepKey: enterCity
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegion
		$I->fillField("input[name=postcode]", "78729"); // stepKey: enterPostcode
		$I->fillField("input[name=telephone]", "1234568910"); // stepKey: enterTelephone
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("Grab customer data to check it");
		$grabEmail = $I->grabValueFrom("input[id*=customer-email]"); // stepKey: grabEmail
		$grabFirstName = $I->grabValueFrom("input[name=firstname]"); // stepKey: grabFirstName
		$grabLastName = $I->grabValueFrom("input[name=lastname]"); // stepKey: grabLastName
		$grabStreet = $I->grabValueFrom("input[name='street[0]']"); // stepKey: grabStreet
		$grabCity = $I->grabValueFrom("input[name=city]"); // stepKey: grabCity
		$grabRegion = $I->grabTextFrom("select[name=region_id]"); // stepKey: grabRegion
		$grabPostcode = $I->grabValueFrom("input[name=postcode]"); // stepKey: grabPostcode
		$grabTelephone = $I->grabValueFrom("input[name=telephone]"); // stepKey: grabTelephone
		$I->comment("Select shipping method and finalize checkout");
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethod
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrl
		$I->comment("Go to cart page, update qty and proceed to checkout");
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->see("Shopping Cart"); // stepKey: seeCartPageIsOpened
		$I->fillField("//input[@data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "'][@title='Qty']", "2"); // stepKey: updateProductQty
		$I->click("#form-validate button[type='submit'].update"); // stepKey: clickUpdateShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickUpdateShoppingCartWaitForPageLoad
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoad
		$grabQty = $I->grabValueFrom("//input[@data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "'][@title='Qty']"); // stepKey: grabQty
		$I->assertEquals(2, $grabQty); // stepKey: assertQty
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Check that form is filled with customer data");
		$grabEmail1 = $I->grabValueFrom("input[id*=customer-email]"); // stepKey: grabEmail1
		$grabFirstName1 = $I->grabValueFrom("input[name=firstname]"); // stepKey: grabFirstName1
		$grabLastName1 = $I->grabValueFrom("input[name=lastname]"); // stepKey: grabLastName1
		$grabStreet1 = $I->grabValueFrom("input[name='street[0]']"); // stepKey: grabStreet1
		$grabCity1 = $I->grabValueFrom("input[name=city]"); // stepKey: grabCity1
		$grabRegion1 = $I->grabTextFrom("select[name=region_id]"); // stepKey: grabRegion1
		$grabPostcode1 = $I->grabValueFrom("input[name=postcode]"); // stepKey: grabPostcode1
		$grabTelephone1 = $I->grabValueFrom("input[name=telephone]"); // stepKey: grabTelephone1
		$I->assertEquals($grabEmail, $grabEmail1); // stepKey: assertEmail
		$I->assertEquals($grabFirstName, $grabFirstName1); // stepKey: assertFirstName
		$I->assertEquals($grabLastName, $grabLastName1); // stepKey: assertLastName
		$I->assertEquals($grabStreet, $grabStreet1); // stepKey: assertStreet
		$I->assertEquals($grabCity, $grabCity1); // stepKey: assertCity
		$I->assertEquals($grabRegion, $grabRegion1); // stepKey: assertRegion
		$I->assertEquals($grabPostcode, $grabPostcode1); // stepKey: assertPostcode
		$I->assertEquals($grabTelephone, $grabTelephone1); // stepKey: assertTelephone
	}
}
