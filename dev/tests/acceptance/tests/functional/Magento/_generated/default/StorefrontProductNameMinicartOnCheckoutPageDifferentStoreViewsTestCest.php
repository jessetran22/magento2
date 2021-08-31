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
 * @Title("MC-28566: Checking Product name in Minicart and on Checkout page with different store views")
 * @Description("Checking Product name in Minicart and on Checkout page with different store views<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontProductNameMinicartOnCheckoutPageDifferentStoreViewsTest.xml<br>")
 * @TestCaseId("MC-28566")
 * @group checkout
 */
class StorefrontProductNameMinicartOnCheckoutPageDifferentStoreViewsTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create a product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToStoresIndexDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitStoreIndexPageLoadDeleteStoreView
		$I->click("button[title='Reset Filter']"); // stepKey: resetSearchFilterDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: resetSearchFilterDeleteStoreViewWaitForPageLoad
		$I->fillField("#storeGrid_filter_store_title", "store" . msq("customStore")); // stepKey: fillStoreViewFilterFieldDeleteStoreView
		$I->waitForPageLoad(90); // stepKey: fillStoreViewFilterFieldDeleteStoreViewWaitForPageLoad
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteStoreViewWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickStoreViewInGridDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: waitForStoreViewPageDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewDeleteStoreViewWaitForPageLoad
		$I->selectOption("select#store_create_backup", "No"); // stepKey: dontCreateDbBackupDeleteStoreView
		$I->click("#delete"); // stepKey: clickDeleteStoreViewAgainDeleteStoreView
		$I->waitForPageLoad(30); // stepKey: clickDeleteStoreViewAgainDeleteStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-title", 30); // stepKey: waitingForWarningModalDeleteStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreDeleteDeleteStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreDeleteDeleteStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSuccessMessageDeleteStoreView
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearsDeleteStoreView
		$I->see("You deleted the store view.", "#messages div.message-success"); // stepKey: seeDeleteMessageDeleteStoreView
		$I->comment("Exiting Action Group [deleteStoreView] AdminDeleteStoreViewActionGroup");
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"Checkout"})
	 * @Stories({"Minicart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductNameMinicartOnCheckoutPageDifferentStoreViewsTest(AcceptanceTester $I)
	{
		$I->comment("Create store view");
		$I->comment("Entering Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreView
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "Main Website Store"); // stepKey: selectStoreCreateStoreView
		$I->fillField("#store_name", "store" . msq("customStore")); // stepKey: enterStoreViewNameCreateStoreView
		$I->fillField("#store_code", "store" . msq("customStore")); // stepKey: enterStoreViewCodeCreateStoreView
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreView
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreView
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreView
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreView
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreView
		$I->comment("Exiting Action Group [createStoreView] AdminCreateStoreViewActionGroup");
		$I->comment("Go to created product page");
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Switch to second store view and change the product name");
		$I->comment("Entering Action Group [switchToCustomStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->scrollTo("//*[@class='page-header row']"); // stepKey: scrollToUpSwitchToCustomStoreView
		$I->waitForElementVisible("#store-change-button", 30); // stepKey: waitForElementBecomeVisibleSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: waitForElementBecomeVisibleSwitchToCustomStoreViewWaitForPageLoad
		$I->click("#store-change-button"); // stepKey: clickStoreviewSwitcherSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: clickStoreviewSwitcherSwitchToCustomStoreViewWaitForPageLoad
		$I->click("//ul[@data-role='stores-list']/li/a[normalize-space(.)='store" . msq("customStore") . "']"); // stepKey: chooseStoreViewSwitchToCustomStoreView
		$I->waitForPageLoad(10); // stepKey: chooseStoreViewSwitchToCustomStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptStoreSwitchingMessageSwitchToCustomStoreView
		$I->waitForPageLoad(60); // stepKey: acceptStoreSwitchingMessageSwitchToCustomStoreViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchToCustomStoreView
		$I->comment("Exiting Action Group [switchToCustomStoreView] SwitchToTheNewStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->click("input[name='use_default[name]']"); // stepKey: uncheckUseDefault
		$I->fillField(".admin__field[data-index=name] input", $I->retrieveEntityField('createProduct', 'name', 'test') . "-new"); // stepKey: fillProductName
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Add product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
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
		$I->comment("Switch to second store view");
		$I->comment("Entering Action Group [switchStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->click("#switcher-language-trigger"); // stepKey: clickStoreViewSwitcherSwitchStoreView
		$I->waitForElementVisible(".active ul.switcher-dropdown", 30); // stepKey: waitForStoreViewDropdownSwitchStoreView
		$I->click("li.view-store" . msq("customStore") . ">a"); // stepKey: clickSelectStoreViewSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSwitchStoreView
		$I->comment("Exiting Action Group [switchStoreView] StorefrontSwitchStoreViewActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStoreView
		$I->comment("Check product name in Minicart");
		$I->comment("Entering Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickCart
		$I->comment("Exiting Action Group [clickCart] StorefrontClickOnMiniCartActionGroup");
		$grabProductNameMinicart = $I->grabTextFrom(".product-item-name"); // stepKey: grabProductNameMinicart
		$I->assertStringContainsString($I->retrieveEntityField('createProduct', 'name', 'test'), $grabProductNameMinicart); // stepKey: assertProductNameMinicart
		$I->assertStringContainsString("-new", $grabProductNameMinicart); // stepKey: assertProductNameMinicart1
		$I->comment("Check product name in Shopping Cart page");
		$I->click(".action.viewcart"); // stepKey: clickViewAndEdit
		$I->waitForPageLoad(30); // stepKey: clickViewAndEditWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShoppingCartPageLoad
		$grabProductNameCart = $I->grabTextFrom("//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: grabProductNameCart
		$I->assertStringContainsString($I->retrieveEntityField('createProduct', 'name', 'test'), $grabProductNameCart); // stepKey: assertProductNameCart
		$I->assertStringContainsString("-new", $grabProductNameCart); // stepKey: assertProductNameCart1
		$I->comment("Proceed to checkout and check product name in Order Summary area");
		$I->comment("Entering Action Group [proceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadProceedToCheckout
		$I->comment("Exiting Action Group [proceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->waitForElementVisible("input[id*=customer-email]", 30); // stepKey: waitForShippingPageLoad
		$I->conditionalClick("div.items-in-cart div.title", "div.items-in-cart.active div.title", false); // stepKey: clickItemInCart
		$I->waitForPageLoad(30); // stepKey: clickItemInCartWaitForPageLoad
		$grabProductNameShipping = $I->grabTextFrom("//strong[@class='product-item-name']"); // stepKey: grabProductNameShipping
		$I->assertStringContainsString($I->retrieveEntityField('createProduct', 'name', 'test'), $grabProductNameShipping); // stepKey: assertProductNameShipping
		$I->assertStringContainsString("-new", $grabProductNameShipping); // stepKey: assertProductNameShipping1
	}
}
