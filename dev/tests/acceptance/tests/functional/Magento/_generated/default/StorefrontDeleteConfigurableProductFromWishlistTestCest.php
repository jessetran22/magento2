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
 * @Title("MC-14217: Delete Configurable Product from Wishlist on Frontend")
 * @Description("Delete Configurable Product from Wishlist on Frontend<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontDeleteConfigurableProductFromWishlistTest.xml<br>")
 * @TestCaseId("MC-14217")
 * @group wishlist
 * @group mtf_migrated
 */
class StorefrontDeleteConfigurableProductFromWishlistTestCest
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
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->comment("Add the attribute just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the first option of the attribute created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the second option of the attribute created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Get the third option of the attribute created");
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "BaseConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create a simple product and give it the attribute with the first option");
		$createConfigChildProduct1Fields['price'] = "10.00";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$createConfigChildProduct2Fields['price'] = "20.00";
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], $createConfigChildProduct2Fields); // stepKey: createConfigChildProduct2
		$I->comment("Create a simple product and give it the attribute with the Third option");
		$createConfigChildProduct3Fields['price'] = "30.00";
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption3"], $createConfigChildProduct3Fields); // stepKey: createConfigChildProduct3
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductThreeOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Add the third simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
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
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	public function StorefrontDeleteConfigurableProductFromWishlistTest(AcceptanceTester $I)
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
		$I->comment("2. Navigate to catalog page");
		$I->comment("Entering Action Group [openProductFromCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenProductFromCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("3. Add created product to Wishlist according to dataset and assert add product to wishlist success message");
		$I->comment("Entering Action Group [addProductToWishlist] StorefrontCustomerAddCategoryProductToWishlistActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: addCategoryProductToWishlistMoveMouseOverProductAddProductToWishlist
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//a[contains(@class, 'towishlist')]"); // stepKey: addCategoryProductToWishlistClickAddProductToWishlistAddProductToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addCategoryProductToWishlistWaitForSuccessMessageAddProductToWishlist
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test') . " has been added to your Wish List.", "div.message-success.success.message"); // stepKey: addCategoryProductToWishlistSeeProductNameAddedToWishlistAddProductToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductToWishlist
		$I->comment("Exiting Action Group [addProductToWishlist] StorefrontCustomerAddCategoryProductToWishlistActionGroup");
		$I->comment("Navigate to My Account > My Wishlist");
		$I->amOnPage("/wishlist/"); // stepKey: amOnWishListPage
		$I->waitForPageLoad(30); // stepKey: waitForWishlistPageLoad
		$I->comment("Click \"Remove item\"");
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollToProduct
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProduct
		$I->click(".products-grid a.btn-remove"); // stepKey: clickRemoveButton
		$I->waitForPageLoad(30); // stepKey: clickRemoveButtonWaitForPageLoad
		$I->comment("Assert Wishlist is empty");
		$I->comment("Entering Action Group [assertWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
		$I->dontSeeElement(".toolbar .pager"); // stepKey: checkThatPagerIsAbsentAssertWishlistIsEmpty
		$I->see("You have no items in your wish list.", ".form-wishlist-items .message.info.empty"); // stepKey: checkNoItemsMessageAssertWishlistIsEmpty
		$I->comment("Exiting Action Group [assertWishlistIsEmpty] StorefrontAssertCustomerWishlistIsEmptyActionGroup");
	}
}
