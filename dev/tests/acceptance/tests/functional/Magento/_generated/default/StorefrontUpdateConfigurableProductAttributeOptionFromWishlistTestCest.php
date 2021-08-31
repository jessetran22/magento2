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
 * @Title("MC-40881: Update Configurable Product Option from Wishlist")
 * @Description("Verify that Configurable Product Option has correct value after navigating to Wishlist Item editing page<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontUpdateConfigurableProductAttributeOptionFromWishlistTest.xml<br>")
 * @TestCaseId("MC-40881")
 * @group catalog
 * @group configurableProduct
 * @group wishlist
 */
class StorefrontUpdateConfigurableProductAttributeOptionFromWishlistTestCest
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
		$I->comment("Create Customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create Product Attribute with two Options");
		$I->createEntity("createConfigurableProductAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: createConfigurableProductAttribute
		$I->createEntity("createAttributeFirstOption", "hook", "productAttributeOption1", ["createConfigurableProductAttribute"], []); // stepKey: createAttributeFirstOption
		$I->createEntity("createAttributeSecondOption", "hook", "productAttributeOption2", ["createConfigurableProductAttribute"], []); // stepKey: createAttributeSecondOption
		$I->comment("Add attribute to Default Attribute Set");
		$I->createEntity("addAttributeToDefaultSet", "hook", "AddToDefaultSet", ["createConfigurableProductAttribute"], []); // stepKey: addAttributeToDefaultSet
		$I->comment("Get Options of created Attribute");
		$I->getEntity("getConfigurableAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createConfigurableProductAttribute"], null, 1); // stepKey: getConfigurableAttributeFirstOption
		$I->getEntity("getConfigurableAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createConfigurableProductAttribute"], null, 2); // stepKey: getConfigurableAttributeSecondOption
		$I->comment("Create Configurable Product");
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProductWithOutCategory", [], []); // stepKey: createConfigurableProduct
		$I->comment("Create first Simple Product and assign Attribute with Option to it");
		$I->createEntity("createFirstChildProduct", "hook", "ApiSimpleOne", ["createConfigurableProductAttribute", "getConfigurableAttributeFirstOption"], []); // stepKey: createFirstChildProduct
		$I->comment("Create second Simple Product and assign Attribute with Option to it");
		$I->createEntity("createSecondChildProduct", "hook", "ApiSimpleOne", ["createConfigurableProductAttribute", "getConfigurableAttributeSecondOption"], []); // stepKey: createSecondChildProduct
		$I->comment("Create Configurable Product Options");
		$I->createEntity("createConfigurableProductOptions", "hook", "ConfigurableProductTwoOptions", ["createConfigurableProduct", "createConfigurableProductAttribute", "getConfigurableAttributeFirstOption", "getConfigurableAttributeSecondOption"], []); // stepKey: createConfigurableProductOptions
		$I->comment("Assign Simple Products to Configurable Product");
		$I->createEntity("addConfigurableProductFirstChild", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createFirstChildProduct"], []); // stepKey: addConfigurableProductFirstChild
		$I->createEntity("addConfigurableProductSecondChild", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createSecondChildProduct"], []); // stepKey: addConfigurableProductSecondChild
		$I->comment("Reindex invalidated indices after Product Attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Configurable Product data");
		$I->deleteEntity("createFirstChildProduct", "hook"); // stepKey: deleteFirstChildProduct
		$I->deleteEntity("createSecondChildProduct", "hook"); // stepKey: deleteSecondChildProduct
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createConfigurableProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Logout from Customer account");
		$I->comment("Entering Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFromStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFromStorefront
		$I->comment("Exiting Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete Customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Reindex invalidated indices after Product Attribute has been created/deleted");
		$reindexInvalidatedIndicesAfterDelete = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndicesAfterDelete
		$I->comment($reindexInvalidatedIndicesAfterDelete);
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
	 * @Stories({"Update from Wishlist"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateConfigurableProductAttributeOptionFromWishlistTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Open Product details page");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigurableProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Select first Drop-down Attribute Option and click 'Add to Wish List' button");
		$I->comment("Entering Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigurableAttributeFirstOption', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectFirstOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOption
		$I->comment("Exiting Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->comment("Entering Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: WaitForWishListAddProductToWishlist
		$I->click("a.action.towishlist"); // stepKey: addProductToWishlistClickAddToWishlistAddProductToWishlist
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: addProductToWishlistWaitForSuccessMessageAddProductToWishlist
		$I->see($I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . " has been added to your Wish List. Click here to continue shopping.", "div.message-success.success.message"); // stepKey: addProductToWishlistSeeProductNameAddedToWishlistAddProductToWishlist
		$I->seeCurrentUrlMatches("~/wishlist_id/\d+/$~"); // stepKey: seeCurrentUrlMatchesAddProductToWishlist
		$I->comment("Exiting Action Group [addProductToWishlist] StorefrontCustomerAddProductToWishlistActionGroup");
		$I->comment("Click 'Edit Item' button from Wishlist page and assert first Option in Drop-down Attribute");
		$I->comment("Entering Action Group [clickEditWishlistItem] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->waitForElementVisible("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']", 30); // stepKey: waitForProductInfoClickEditWishlistItem
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollToProductClickEditWishlistItem
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProductClickEditWishlistItem
		$I->click(".products-grid a.action.edit"); // stepKey: clickEditButtonClickEditWishlistItem
		$I->waitForPageLoad(30); // stepKey: clickEditButtonClickEditWishlistItemWaitForPageLoad
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: waitForProductPageLoadClickEditWishlistItem
		$I->comment("Exiting Action Group [clickEditWishlistItem] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->comment("Entering Action Group [assertAttributeFirstOption] AssertStorefrontProductDropDownOptionValueActionGroup");
		$I->waitForElementVisible("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "']]//select", 30); // stepKey: waitForAttributeVisibleAssertAttributeFirstOption
		$I->seeOptionIsSelected("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "']]//select", $I->retrieveEntityField('getConfigurableAttributeFirstOption', 'label', 'test')); // stepKey: assertAttributeOptionAssertAttributeFirstOption
		$I->comment("Exiting Action Group [assertAttributeFirstOption] AssertStorefrontProductDropDownOptionValueActionGroup");
		$I->comment("Select second Drop-down Option and click 'Update Wish List' button");
		$I->comment("Entering Action Group [selectSecondOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigurableAttributeSecondOption', 'label', 'test')); // stepKey: fillDropDownAttributeOptionSelectSecondOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectSecondOption
		$I->comment("Exiting Action Group [selectSecondOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->click("a.action.towishlist"); // stepKey: clickUpdateWishlist
		$I->comment("Click 'Edit Item' button again and assert second Option in Drop-down Attribute");
		$I->comment("Entering Action Group [clickEditWishlistItemAgain] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->waitForElementVisible("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']", 30); // stepKey: waitForProductInfoClickEditWishlistItemAgain
		$I->scrollTo("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: scrollToProductClickEditWishlistItemAgain
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigurableProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: mouseOverOnProductClickEditWishlistItemAgain
		$I->click(".products-grid a.action.edit"); // stepKey: clickEditButtonClickEditWishlistItemAgain
		$I->waitForPageLoad(30); // stepKey: clickEditButtonClickEditWishlistItemAgainWaitForPageLoad
		$I->waitForElementVisible("a.action.towishlist", 30); // stepKey: waitForProductPageLoadClickEditWishlistItemAgain
		$I->comment("Exiting Action Group [clickEditWishlistItemAgain] StorefrontCustomerUpdateWishlistItemActionGroup");
		$I->comment("Entering Action Group [assertAttributeSecondOption] AssertStorefrontProductDropDownOptionValueActionGroup");
		$I->waitForElementVisible("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "']]//select", 30); // stepKey: waitForAttributeVisibleAssertAttributeSecondOption
		$I->seeOptionIsSelected("//div[@class='fieldset']//div[//span[text()='" . $I->retrieveEntityField('createConfigurableProductAttribute', 'default_frontend_label', 'test') . "']]//select", $I->retrieveEntityField('getConfigurableAttributeSecondOption', 'label', 'test')); // stepKey: assertAttributeOptionAssertAttributeSecondOption
		$I->comment("Exiting Action Group [assertAttributeSecondOption] AssertStorefrontProductDropDownOptionValueActionGroup");
	}
}
