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
 * @Title("MC-14686: Storefront Delete Simple Product From Mini Shopping Cart Test")
 * @Description("Test log in to Shopping Cart and Delete Simple Product From Mini Shopping Cart Test<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontDeleteSimpleProductFromMiniShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14686")
 * @group Shopping Cart
 * @group mtf_migrated
 */
class StorefrontDeleteSimpleProductFromMiniShoppingCartTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"DeleteSimpleProduct"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteSimpleProductFromMiniShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add Simple Product to the cart");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Assert Product in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$10.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeProductInMiniCart
		$I->comment("Exiting Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Remove an item from the cart using minicart");
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
		$I->reloadPage(); // stepKey: reloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Check the minicart is empty and verify AssertProductAbsentInMiniShoppingCart");
		$I->comment("Entering Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountMiniCartEnpty
		$I->click("a.showcart"); // stepKey: expandMinicartMiniCartEnpty
		$I->waitForPageLoad(60); // stepKey: expandMinicartMiniCartEnptyWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageMiniCartEnpty
		$I->comment("Exiting Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSee("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct', 'name', 'test') . "')]"); // stepKey: verifyAssertProductAbsentInMiniShoppingCart
	}
}
