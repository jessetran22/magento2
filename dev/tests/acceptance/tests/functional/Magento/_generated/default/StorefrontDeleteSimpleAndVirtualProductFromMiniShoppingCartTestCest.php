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
 * @Title("MC-14685: Storefront Delete Simple And Virtual Product From Mini Shopping Cart Test")
 * @Description("Test log in to Shopping Cart and Delete Simple And Virtual Product From Mini Shopping Cart Test<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontDeleteSimpleAndVirtualProductFromMiniShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14685")
 * @group Shopping Cart
 * @group mtf_migrated
 */
class StorefrontDeleteSimpleAndVirtualProductFromMiniShoppingCartTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create  simple product");
		$simpleProductFields['price'] = "10.00";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
		$I->comment("Create  virtual product");
		$virtualProductFields['price'] = "20.00";
		$I->createEntity("virtualProduct", "hook", "VirtualProduct", [], $virtualProductFields); // stepKey: virtualProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("virtualProduct", "hook"); // stepKey: deleteVirtualproduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"DeleteSimpleAndVirtualProduct"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteSimpleAndVirtualProductFromMiniShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add Simple Product to the cart");
		$I->comment("Entering Action Group [addSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Add virtual Product to the cart");
		$I->amOnPage("/" . $I->retrieveEntityField('virtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontVirtualProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Entering Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct1ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct1ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct1ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToTheCart
		$I->comment("Exiting Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert Simple and Virtual products in mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSimpleProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProductInMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProductInMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProductInMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProductInMiniCart
		$I->see("$30.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProductInMiniCart
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProductInMiniCart
		$I->comment("Exiting Action Group [assertSimpleProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Entering Action Group [assertVirtualProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$20.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertVirtualProductInMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertVirtualProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertVirtualProductInMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('virtualProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertVirtualProductInMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertVirtualProductInMiniCart
		$I->see("$30.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertVirtualProductInMiniCart
		$I->see($I->retrieveEntityField('virtualProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertVirtualProductInMiniCart
		$I->comment("Exiting Action Group [assertVirtualProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Select mini Cart and verify Simple and Virtual products names in cart");
		$I->comment("Entering Action Group [seeSimpleProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeSimpleProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeSimpleProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeSimpleProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeSimpleProductInMiniCart
		$I->comment("Exiting Action Group [seeSimpleProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [seeVirtualProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeVirtualProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeVirtualProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeVirtualProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('virtualProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeVirtualProductInMiniCart
		$I->comment("Exiting Action Group [seeVirtualProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Remove Simple and Virtual products from mini cart");
		$I->comment("Entering Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveProductFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCartWaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveProductFromMiniCart
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveProductFromMiniCart
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveProductFromMiniCart
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveProductFromMiniCart
		$I->comment("Exiting Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->comment("Entering Action Group [removeVirtualProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveVirtualProductFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveVirtualProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveVirtualProductFromMiniCartWaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('virtualProduct', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveVirtualProductFromMiniCart
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveVirtualProductFromMiniCart
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveVirtualProductFromMiniCart
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveVirtualProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveVirtualProductFromMiniCart
		$I->comment("Exiting Action Group [removeVirtualProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Check the minicart is empty and verify EmptyCartMessage and AssertProductAbsentInMiniShoppingCart");
		$I->comment("Entering Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountMiniCartEnpty
		$I->click("a.showcart"); // stepKey: expandMinicartMiniCartEnpty
		$I->waitForPageLoad(60); // stepKey: expandMinicartMiniCartEnptyWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageMiniCartEnpty
		$I->comment("Exiting Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSee("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]"); // stepKey: verifyAssertSimpleProductAbsentInMiniShoppingCart
		$I->dontSee("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('virtualProduct', 'name', 'test') . "')]"); // stepKey: verifyAssertVirtualProductAbsentInMiniShoppingCart
	}
}
