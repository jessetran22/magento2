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
 * @Title("MC-40586: Add Dynamic Bundle Product with selected option to Wishlist")
 * @Description("Add Dynamic Bundle Product with selected option to Wishlist on Frontend<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontAddBundleProductWithOptionToWishlistTest.xml<br>")
 * @TestCaseId("MC-40586")
 * @group wishlist
 */
class StorefrontAddBundleProductWithOptionToWishlistTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$simpleProduct1Fields['price'] = "100.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "20.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleProduct
		$I->createEntity("createBundleOption", "hook", "DropDownBundleOption", ["createBundleProduct"], []); // stepKey: createBundleOption
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->createEntity("linkOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption", "simpleProduct2"], []); // stepKey: linkOptionToProduct2
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
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
	public function StorefrontAddBundleProductWithOptionToWishlistTest(AcceptanceTester $I)
	{
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
		$I->selectOption("//label//span[contains(text(), '" . $I->retrieveEntityField('createBundleOption', 'title', 'test') . "')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " +$100.00"); // stepKey: selectOption
		$I->comment("Entering Action Group [addBundleProductWithOptionToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddBundleProductWithOptionToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddBundleProductWithOptionToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddBundleProductWithOptionToWishlist
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddBundleProductWithOptionToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddBundleProductWithOptionToWishlist
		$I->comment("Exiting Action Group [addBundleProductWithOptionToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Entering Action Group [assertProductWithOptionInWishList] AssertProductIsPresentInWishListActionGroup");
		$I->amOnPage("/wishlist/"); // stepKey: goToWishListAssertProductWithOptionInWishList
		$I->waitForPageLoad(30); // stepKey: waitForWishListAssertProductWithOptionInWishList
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductWithOptionInWishList
		$I->see("$100", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductWithOptionInWishList
		$I->comment("Exiting Action Group [assertProductWithOptionInWishList] AssertProductIsPresentInWishListActionGroup");
	}
}
