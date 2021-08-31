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
 * @Title("MC-14683: Storefront Delete Downloadable Product From Mini Shopping Cart Test")
 * @Description("Test log in to Shopping Cart and Delete Downloadable Product From Mini Shopping Cart Test<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontDeleteDownloadableProductFromMiniShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14683")
 * @group Shopping Cart
 * @group mtf_migrated
 */
class StorefrontDeleteDownloadableProductFromMiniShoppingCartTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRateDefaultPrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRateDefaultPrice
		$I->comment($enableFlatRateDefaultPrice);
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createDownloadableProduct"], []); // stepKey: addDownloadableLink1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"DeleteConfigurableProduct"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteDownloadableProductFromMiniShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Downloadable Product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Add Downloadable product to the cart");
		$I->comment("Entering Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToTheCart
		$I->see("You added " . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToTheCart
		$I->comment("Exiting Action Group [addToTheCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartSelectViewAndEditCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartSelectViewAndEditCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSelectViewAndEditCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartSelectViewAndEditCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectViewAndEditCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlSelectViewAndEditCart
		$I->comment("Exiting Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Assert product details in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$123.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertMiniCart
		$I->see("123.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertMiniCart
		$I->see($I->retrieveEntityField('createDownloadableProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertMiniCart
		$I->comment("Exiting Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSeeProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSeeProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createDownloadableProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartSeeProductInMiniCart
		$I->comment("Exiting Action Group [seeProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Remove an item from the cart using minicart");
		$I->comment("Entering Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartRemoveProductFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForMiniCartOpenRemoveProductFromMiniCartWaitForPageLoad
		$I->click("//ol[@id='mini-cart']//div[contains(., '" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "')]//a[contains(@class, 'delete')]"); // stepKey: clickDeleteRemoveProductFromMiniCart
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalRemoveProductFromMiniCart
		$I->see("Are you sure you would like to remove this item from the shopping cart?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageRemoveProductFromMiniCart
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteRemoveProductFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinishRemoveProductFromMiniCart
		$I->comment("Exiting Action Group [removeProductFromMiniCart] RemoveProductFromMiniCartActionGroup");
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Check the minicart is empty and verify AssertProductAbsentInMiniShoppingCart");
		$I->comment("Entering Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSeeElement("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: dontSeeMinicartProductCountMiniCartEnpty
		$I->click("a.showcart"); // stepKey: expandMinicartMiniCartEnpty
		$I->waitForPageLoad(60); // stepKey: expandMinicartMiniCartEnptyWaitForPageLoad
		$I->see("You have no items in your shopping cart.", "#minicart-content-wrapper"); // stepKey: seeEmptyCartMessageMiniCartEnpty
		$I->comment("Exiting Action Group [miniCartEnpty] AssertMiniCartEmptyActionGroup");
		$I->dontSee("//header//ol[@id='mini-cart']//div[@class='product-item-details']//a[contains(text(), '" . $I->retrieveEntityField('createDownloadableProduct', 'name', 'test') . "')]"); // stepKey: verifyAssertProductAbsentInMiniShoppingCart
	}
}
