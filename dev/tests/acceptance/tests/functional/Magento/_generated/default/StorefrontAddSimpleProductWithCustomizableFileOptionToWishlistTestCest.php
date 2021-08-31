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
 * @Title("MC-41040: Add simple product with customizable file option to wishlist")
 * @Description("Add simple Product with customizable file option to Wishlist and verify customizable options are preserved<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontAddSimpleProductWithCustomizableFileOptionToWishlistTest.xml<br>")
 * @TestCaseId("MC-41040")
 * @group wishlist
 */
class StorefrontAddSimpleProductWithCustomizableFileOptionToWishlistTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$createProductFields['price'] = "100.00";
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], $createProductFields); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "productWithFileOption",["createProduct"]); // stepKey: updateProductWithOptions
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct1
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
	 * @Features({"Wishlist"})
	 * @Stories({"Add product to wishlist"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddSimpleProductWithCustomizableFileOptionToWishlistTest(AcceptanceTester $I)
	{
		$I->comment("Login as a customer");
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
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "adobe-base.jpg"); // stepKey: fillUploadFile
		$I->comment("Add product to the wishlist");
		$I->comment("Entering Action Group [addProductWithOptionToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddProductWithOptionToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddProductWithOptionToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddProductWithOptionToWishlist
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddProductWithOptionToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductWithOptionToWishlist
		$I->comment("Exiting Action Group [addProductWithOptionToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Assert product is present in wishlist");
		$I->comment("Entering Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->amOnPage("/wishlist/"); // stepKey: goToWishListAssertProductPresent
		$I->waitForPageLoad(30); // stepKey: waitForWishListAssertProductPresent
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductPresent
		$I->see("$109.99", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPresent
		$I->comment("Exiting Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->comment("Edit wishlist product");
		$I->comment("Entering Action Group [clickEditWishlistItem] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->waitForElementVisible("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']", 30); // stepKey: waitForProductInfoClickEditWishlistItem
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollToProductClickEditWishlistItem
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProductClickEditWishlistItem
		$I->click(".products-grid a.action.edit"); // stepKey: clickEditButtonClickEditWishlistItem
		$I->waitForPageLoad(30); // stepKey: clickEditButtonClickEditWishlistItemWaitForPageLoad
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: waitForProductPageLoadClickEditWishlistItem
		$I->comment("Exiting Action Group [clickEditWishlistItem] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->comment("Update product in wishlist from product page");
		$I->comment("Entering Action Group [updateProductWithOptionInWishlist] StorefrontCustomerUpdateProductInWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListUpdateProductWithOptionInWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistUpdateProductWithOptionInWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageUpdateProductWithOptionInWishlist
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test') . " has been updated in your Wish List.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistUpdateProductWithOptionInWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesUpdateProductWithOptionInWishlist
		$I->comment("Exiting Action Group [updateProductWithOptionInWishlist] StorefrontCustomerUpdateProductInWishlistActionGroup");
		$I->comment("Entering Action Group [assertProductPresent2] AssertProductIsPresentInWishListActionGroup");
		$I->amOnPage("/wishlist/"); // stepKey: goToWishListAssertProductPresent2
		$I->waitForPageLoad(30); // stepKey: waitForWishListAssertProductPresent2
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductPresent2
		$I->see("$109.99", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPresent2
		$I->comment("Exiting Action Group [assertProductPresent2] AssertProductIsPresentInWishListActionGroup");
	}
}
