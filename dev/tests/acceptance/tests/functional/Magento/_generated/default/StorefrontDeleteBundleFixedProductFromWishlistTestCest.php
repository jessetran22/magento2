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
 * @Title("MC-14216: Delete Fixed Bundle Product from Wishlist on Frontend")
 * @Description("Delete Fixed Bundle Product from Wishlist on Frontend<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontDeleteBundleFixedProductFromWishlistTest.xml<br>")
 * @TestCaseId("MC-14216")
 * @group wishlist
 * @group mtf_migrated
 */
class StorefrontDeleteBundleFixedProductFromWishlistTestCest
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
		$simpleProduct2Fields['price'] = "100.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->comment("Create bundle product");
		$I->createEntity("createBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createBundleProduct
		$I->createEntity("createBundleOption1_1", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: createBundleOption1_1
		$createBundleLinkFields['price_type'] = "0";
		$I->createEntity("createBundleLink", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], $createBundleLinkFields); // stepKey: createBundleLink
		$linkOptionToProduct2Fields['price_type'] = "0";
		$I->createEntity("linkOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct2"], $linkOptionToProduct2Fields); // stepKey: linkOptionToProduct2
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Wishlist"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteBundleFixedProductFromWishlistTest(AcceptanceTester $I)
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
		$I->comment("Navigate to catalog page");
		$I->comment("Entering Action Group [openProductFromCategory] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductFromCategory
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenStoreFrontProductPageActionGroup");
		$I->comment("Add created product to Wishlist according to dataset and assert add product to wishlist success message");
		$I->comment("Entering Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddProductToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddProductToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddProductToWishlist
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddProductToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductToWishlist
		$I->comment("Exiting Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Navigate to My Account > My Wishlist");
		$I->amOnPage("/wishlist/"); // stepKey: amOnWishListPage
		$I->waitForPageLoad(30); // stepKey: waitForWishlistPageLoad
		$I->comment("Click \"Remove item\"");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollToProduct
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProduct
		$I->click(".products-grid a.btn-remove"); // stepKey: clickRemoveButton
		$I->waitForPageLoad(30); // stepKey: clickRemoveButtonWaitForPageLoad
		$I->comment("Assert Wishlist is empty");
		$I->comment("Entering Action Group [assertWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
		$I->dontSeeElement(".toolbar .pager"); // stepKey: checkThatPagerIsAbsentAssertWishlistIsEmpty
		$I->see("You have no items in your wish list.", ".form-wishlist-items .message.info.empty"); // stepKey: checkNoItemsMessageAssertWishlistIsEmpty
		$I->comment("Exiting Action Group [assertWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
	}
}
