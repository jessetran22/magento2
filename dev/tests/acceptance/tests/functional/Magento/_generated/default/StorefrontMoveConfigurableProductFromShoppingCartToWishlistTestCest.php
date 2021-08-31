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
 * @Title("MC-14211: Move Configurable Product from Shopping Cart to Wishlist")
 * @Description("Move Configurable Product from Shopping Cart to Wishlist<h3>Test files</h3>app/code/Magento/Wishlist/Test/Mftf/Test/StorefrontMoveConfigurableProductFromShoppingCartToWishlistTest.xml<br>")
 * @TestCaseId("MC-14211")
 * @group wishlist
 * @group mtf_migrated
 */
class StorefrontMoveConfigurableProductFromShoppingCartToWishlistTestCest
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
		$I->comment("Create an attribute with three options to be used in the first child product");
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
	public function StorefrontMoveConfigurableProductFromShoppingCartToWishlistTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenProductFromCategory
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]"); // stepKey: openProductPageOpenProductFromCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: selectOption1
		$I->scrollTo("a.action.towishlist", -200); // stepKey: scroll
		$I->comment("Add product to the cart and Assert add product to cart success message");
		$I->comment("Entering Action Group [addToCartVirtualProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartVirtualProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartVirtualProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartVirtualProductFromStorefrontProductPage
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
		$I->click("//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/ancestor::tbody/tr//a[contains(@class, 'towishlist')]"); // stepKey: moveToWishlistMoveToWishlist
		$I->waitForPageLoad(30); // stepKey: waitForMoveMoveToWishlist
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test') . " has been moved to your wish list.", ".message.message-success.success>div"); // stepKey: assertSuccessMoveToWishlist
		$I->comment("Exiting Action Group [moveToWishlist] AssertMoveProductToWishListSuccessMessageActionGroup");
		$I->comment("Assert product is present in wishlist");
		$I->comment("Entering Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->amOnPage("/wishlist/"); // stepKey: goToWishListAssertProductPresent
		$I->waitForPageLoad(30); // stepKey: waitForWishListAssertProductPresent
		$I->waitForElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductPresent
		$I->see("$20.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPresent
		$I->comment("Exiting Action Group [assertProductPresent] AssertProductIsPresentInWishListActionGroup");
		$I->comment("Assert product details in Wishlist");
		$I->comment("Entering Action Group [assertProductDetails] AssertProductDetailsInWishlistActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductInfoAssertProductDetails
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//button[contains(@class, 'action tocart primary')]"); // stepKey: seeAddToCartAssertProductDetails
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]]//img[@class='product-image-photo']"); // stepKey: seeImageAssertProductDetails
		$I->moveMouseOver("//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]"); // stepKey: moveMouseOverProductDetailsAssertProductDetails
		$I->see($I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test'), "//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]//dt[@class='label']"); // stepKey: seeLabelAssertProductDetails
		$I->see($I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), "//a[contains(text(), '" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/ancestor::div/div[contains(@class, 'product-item-tooltip')]//dd[@class='values']"); // stepKey: seeLabelValueAssertProductDetails
		$I->comment("Exiting Action Group [assertProductDetails] AssertProductDetailsInWishlistActionGroup");
		$I->comment("Entering Action Group [assertCartIsEmpty] AssertShoppingCartIsEmptyActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: amOnPageShoppingCartAssertCartIsEmpty
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadAssertCartIsEmpty
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartAssertCartIsEmpty
		$I->comment("Exiting Action Group [assertCartIsEmpty] AssertShoppingCartIsEmptyActionGroup");
	}
}
