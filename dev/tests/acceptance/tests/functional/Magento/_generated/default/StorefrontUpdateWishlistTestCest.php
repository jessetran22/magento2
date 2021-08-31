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
 * @Title("MAGETWO-94296: Displaying of message after Wish List update")
 * @Description("Displaying of message after Wish List update<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontUpdateWishlistTest.xml<br>")
 * @TestCaseId("MAGETWO-94296")
 * @group Wishlist
 */
class StorefrontUpdateWishlistTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"MAGETWO-91666: Wishlist update does not return a success message"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Wishlist"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateWishlistTest(AcceptanceTester $I)
	{
		$I->comment("Perform reindex and flush cache");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenProductFromCategory
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: openProductPageOpenProductFromCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddProductToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddProductToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddProductToWishlist
		$I->see($I->retrieveEntityField('product', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddProductToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductToWishlist
		$I->comment("Exiting Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Entering Action Group [checkProductInWishlist] StorefrontCustomerCheckProductInWishlistActionGroup");
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]", 30); // stepKey: assertWishlistProductNameCheckProductInWishlist
		$I->see("$" . $I->retrieveEntityField('product', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertWishlistProductPriceCheckProductInWishlist
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: wishlistMoveMouseOverProductCheckProductInWishlist
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//button[contains(@class, 'action tocart primary')]"); // stepKey: AssertWishlistAddToCartCheckProductInWishlist
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: AssertWishlistProductImageCheckProductInWishlist
		$I->comment("Exiting Action Group [checkProductInWishlist] StorefrontCustomerCheckProductInWishlistActionGroup");
		$I->comment("Entering Action Group [updateProductInWishlist] StorefrontCustomerEditProductInWishlistActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProductUpdateProductInWishlist
		$I->fillField("//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]/ancestor::div[@class='product-item-info']//textarea[@class='product-item-comment']", "some text"); // stepKey: fillDescriptionUpdateProductInWishlist
		$I->fillField("//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]/ancestor::div[@class='product-item-info']//input[@class='input-text qty']", "2"); // stepKey: fillQuantityUpdateProductInWishlist
		$I->moveMouseOver(".column.main .actions-toolbar .action.tocart"); // stepKey: mouseOverUpdateProductInWishlist
		$I->waitForPageLoad(30); // stepKey: mouseOverUpdateProductInWishlistWaitForPageLoad
		$I->click(".column.main .actions-toolbar .action.update"); // stepKey: submitUpdateWishlistUpdateProductInWishlist
		$I->waitForPageLoad(30); // stepKey: submitUpdateWishlistUpdateProductInWishlistWaitForPageLoad
		$I->see($I->retrieveEntityField('product', 'name', 'test') . " has been updated in your Wish List.", "//div[1]/div[2]/div/div/div"); // stepKey: successMessageUpdateProductInWishlist
		$I->comment("Exiting Action Group [updateProductInWishlist] StorefrontCustomerEditProductInWishlistActionGroup");
	}
}
