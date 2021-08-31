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
 * @Title("MC-14212: Move Dynamic Bundle Product from Shopping Cart to Wishlist")
 * @Description("Move Dynamic Bundle Product from Shopping Cart to Wishlist<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontMoveDynamicBundleProductFromShoppingCartToWishlistTest.xml<br>")
 * @TestCaseId("MC-14212")
 * @group wishlist
 * @group mtf_migrated
 */
class StorefrontMoveDynamicBundleProductFromShoppingCartToWishlistTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Data");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$simpleProduct1Fields['price'] = "100.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "20.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->comment("Create Bundle product");
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleProduct
		$I->createEntity("createBundleOption1_1", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: createBundleOption1_1
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->createEntity("linkOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct2"], []); // stepKey: linkOptionToProduct2
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createBundleProduct', 'id', 'hook')); // stepKey: goToProductGoToProduct
		$I->comment("Exiting Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->scrollTo("div[data-index='content']"); // stepKey: scrollToBundleSection
		$I->waitForPageLoad(30); // stepKey: scrollToBundleSectionWaitForPageLoad
		$I->selectOption(".admin__control-select[name='product[shipment_type]']", "Separately"); // stepKey: selectSeparately
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$runCronIndex = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete data");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
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
	 * @Stories({"Wishlist"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Wishlist"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontMoveDynamicBundleProductFromShoppingCartToWishlistTest(AcceptanceTester $I)
	{
		$I->comment("1. Login as a customer");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Open Product page");
		$I->comment("Entering Action Group [openProductFromCategory] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductFromCategory
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [clickCustomizeButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeButtonWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeButton
		$I->comment("Exiting Action Group [clickCustomizeButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->selectOption("//label//span[contains(text(), '" . $I->retrieveEntityField('createBundleOption1_1', 'title', 'test') . "')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " +$100.00"); // stepKey: selectOption0Product0
		$I->fillField("//span[contains(text(), '" . $I->retrieveEntityField('createBundleOption1_1', 'title', 'test') . "')]/../..//input", "1"); // stepKey: fillQuantity00
		$I->comment("Add product to the cart and Assert add product to cart success message");
		$I->comment("Entering Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
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
		$I->comment("Assert move product to wishlist success message");
		$I->comment("Entering Action Group [moveToWishlist] AssertMoveProductToWishListSuccessMessageActionGroup");
		$I->click("//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/ancestor::tbody/tr//a[contains(@class, 'towishlist')]"); // stepKey: moveToWishlistMoveToWishlist
		$I->waitForPageLoad(30); // stepKey: waitForMoveMoveToWishlist
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test') . " has been moved to your wish list.", ".message.message-success.success>div"); // stepKey: assertSuccessMoveToWishlist
		$I->comment("Exiting Action Group [moveToWishlist] AssertMoveProductToWishListSuccessMessageActionGroup");
		$I->comment("Assert product is present in wishlist");
		$I->comment("Entering Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->amOnPage("/wishlist/"); // stepKey: goToWishListAssertProductPresent
		$I->waitForPageLoad(30); // stepKey: waitForWishListAssertProductPresent
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductPresent
		$I->see("$100.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPresent
		$I->comment("Exiting Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->comment("Assert product details in Wishlist");
		$I->comment("Entering Action Group [assertProductDetails] AssertProductDetailsInWishlistActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductInfoAssertProductDetails
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//button[contains(@class, 'action tocart primary')]"); // stepKey: seeAddToCartAssertProductDetails
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: seeImageAssertProductDetails
		$I->moveMouseOver("//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]"); // stepKey: moveMouseOverProductDetailsAssertProductDetails
		$I->see($I->retrieveEntityField('createBundleOption1_1', 'title', 'test'), "//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]//dt[@class='label']"); // stepKey: seeLabelAssertProductDetails
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $100.00", "//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]//dd[@class='values']"); // stepKey: seeLabelValueAssertProductDetails
		$I->comment("Exiting Action Group [assertProductDetails] AssertProductDetailsInWishlistActionGroup");
		$I->comment("Entering Action Group [assertCartIsEmpty] AssertShoppingCartIsEmptyActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: amOnPageShoppingCartAssertCartIsEmpty
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadAssertCartIsEmpty
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartAssertCartIsEmpty
		$I->comment("Exiting Action Group [assertCartIsEmpty] AssertShoppingCartIsEmptyActionGroup");
	}
}
