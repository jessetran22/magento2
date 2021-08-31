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
 * @Title("MAGETWO-98968: Check tier prices for bundle options")
 * @Description("Check tier prices for bundle options<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontCheckBundleProductOptionTierPricesTest.xml<br>")
 * @TestCaseId("MAGETWO-98968")
 * @group catalog
 * @group bundle
 */
class StorefrontCheckBundleProductOptionTierPricesTestCest
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
		$I->comment("Create Dynamic Bundle product");
		$I->comment("Entering Action Group [createBundleProduct] AdminCreateApiDynamicBundleProductAllOptionTypesActionGroup");
		$I->comment("Create simple products");
		$simpleProduct1CreateBundleProductFields['price'] = "10";
		$I->createEntity("simpleProduct1CreateBundleProduct", "hook", "SimpleProduct2", [], $simpleProduct1CreateBundleProductFields); // stepKey: simpleProduct1CreateBundleProduct
		$simpleProduct2CreateBundleProductFields['price'] = "20";
		$I->createEntity("simpleProduct2CreateBundleProduct", "hook", "SimpleProduct2", [], $simpleProduct2CreateBundleProductFields); // stepKey: simpleProduct2CreateBundleProduct
		$I->comment("Create Bundle product");
		$createBundleProductCreateBundleProductFields['name'] = "Api Dynamic Bundle Product";
		$I->createEntity("createBundleProductCreateBundleProduct", "hook", "ApiBundleProduct", [], $createBundleProductCreateBundleProductFields); // stepKey: createBundleProductCreateBundleProduct
		$createDropDownBundleOptionCreateBundleProductFields['title'] = "Drop-down Option";
		$I->createEntity("createDropDownBundleOptionCreateBundleProduct", "hook", "DropDownBundleOption", ["createBundleProductCreateBundleProduct"], $createDropDownBundleOptionCreateBundleProductFields); // stepKey: createDropDownBundleOptionCreateBundleProduct
		$createBundleRadioButtonsOptionCreateBundleProductFields['title'] = "Radio Buttons Option";
		$I->createEntity("createBundleRadioButtonsOptionCreateBundleProduct", "hook", "RadioButtonsOption", ["createBundleProductCreateBundleProduct"], $createBundleRadioButtonsOptionCreateBundleProductFields); // stepKey: createBundleRadioButtonsOptionCreateBundleProduct
		$createBundleCheckboxOptionCreateBundleProductFields['title'] = "Checkbox Option";
		$I->createEntity("createBundleCheckboxOptionCreateBundleProduct", "hook", "CheckboxOption", ["createBundleProductCreateBundleProduct"], $createBundleCheckboxOptionCreateBundleProductFields); // stepKey: createBundleCheckboxOptionCreateBundleProduct
		$I->createEntity("linkCheckboxOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleCheckboxOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkCheckboxOptionToProduct1CreateBundleProduct
		$I->createEntity("linkCheckboxOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleCheckboxOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkCheckboxOptionToProduct2CreateBundleProduct
		$I->createEntity("linkDropDownOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createDropDownBundleOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkDropDownOptionToProduct1CreateBundleProduct
		$I->createEntity("linkDropDownOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createDropDownBundleOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkDropDownOptionToProduct2CreateBundleProduct
		$I->createEntity("linkRadioButtonsOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleRadioButtonsOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkRadioButtonsOptionToProduct1CreateBundleProduct
		$I->createEntity("linkRadioButtonsOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleRadioButtonsOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkRadioButtonsOptionToProduct2CreateBundleProduct
		$runCronIndexCreateBundleProduct = $I->magentoCron("index", 90); // stepKey: runCronIndexCreateBundleProduct
		$I->comment($runCronIndexCreateBundleProduct);
		$I->comment("Exiting Action Group [createBundleProduct] AdminCreateApiDynamicBundleProductAllOptionTypesActionGroup");
		$I->comment("Add tier prices to simple products");
		$I->comment("Simple product 1");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openAdminEditPageProduct1] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'id', 'hook')); // stepKey: goToProductOpenAdminEditPageProduct1
		$I->comment("Exiting Action Group [openAdminEditPageProduct1] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addTierPriceProduct1] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonAddTierPriceProduct1
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonAddTierPriceProduct1WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceProduct1
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceProduct1WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceProduct1
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceProduct1WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2AddTierPriceProduct1
		$I->selectOption("[name='product[tier_price][0][website_id]']", ""); // stepKey: selectProductWebsiteValueAddTierPriceProduct1
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: selectProductCustomGroupValueAddTierPriceProduct1
		$I->fillField("[name='product[tier_price][0][price_qty]']", "5"); // stepKey: fillProductTierPriceQtyInputAddTierPriceProduct1
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeAddTierPriceProduct1
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "50"); // stepKey: selectProductTierPricePriceInputAddTierPriceProduct1
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddTierPriceProduct1
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddTierPriceProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveAddTierPriceProduct1
		$I->click("#save-button"); // stepKey: clickSaveProduct1AddTierPriceProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1AddTierPriceProduct1WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1AddTierPriceProduct1
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationAddTierPriceProduct1
		$I->comment("Exiting Action Group [addTierPriceProduct1] ProductSetAdvancedPricingActionGroup");
		$I->comment("Simple product 2");
		$I->comment("Entering Action Group [openAdminEditPageProduct2] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'id', 'hook')); // stepKey: goToProductOpenAdminEditPageProduct2
		$I->comment("Exiting Action Group [openAdminEditPageProduct2] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addTierPriceProduct2] ProductSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonAddTierPriceProduct2
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonAddTierPriceProduct2WaitForPageLoad
		$I->waitForElementVisible("[data-action='add_new_row']", 30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceProduct2
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupPriceAddButtonAddTierPriceProduct2WaitForPageLoad
		$I->click("[data-action='add_new_row']"); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceProduct2
		$I->waitForPageLoad(30); // stepKey: addCustomerGroupAllGroupsQty1PriceDiscountAnd10percentAddTierPriceProduct2WaitForPageLoad
		$I->waitForElement("[name='product[tier_price][0][cust_group]']", 30); // stepKey: waitForSelectCustomerGroupNameAttribute2AddTierPriceProduct2
		$I->selectOption("[name='product[tier_price][0][website_id]']", ""); // stepKey: selectProductWebsiteValueAddTierPriceProduct2
		$I->selectOption("[name='product[tier_price][0][cust_group]']", "ALL GROUPS"); // stepKey: selectProductCustomGroupValueAddTierPriceProduct2
		$I->fillField("[name='product[tier_price][0][price_qty]']", "7"); // stepKey: fillProductTierPriceQtyInputAddTierPriceProduct2
		$I->selectOption("[name='product[tier_price][0][value_type]']", "Discount"); // stepKey: selectProductTierPriceValueTypeAddTierPriceProduct2
		$I->fillField("[name='product[tier_price][0][percentage_value]']", "25"); // stepKey: selectProductTierPricePriceInputAddTierPriceProduct2
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonAddTierPriceProduct2
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonAddTierPriceProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: WaitForProductSaveAddTierPriceProduct2
		$I->click("#save-button"); // stepKey: clickSaveProduct1AddTierPriceProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProduct1AddTierPriceProduct2WaitForPageLoad
		$I->waitForPageLoad(60); // stepKey: WaitForProductSave1AddTierPriceProduct2
		$I->see("You saved the product."); // stepKey: seeSaveConfirmationAddTierPriceProduct2
		$I->comment("Exiting Action Group [addTierPriceProduct2] ProductSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [logoutAsAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsAdmin
		$I->comment("Exiting Action Group [logoutAsAdmin] AdminLogoutActionGroup");
		$runCronIndex = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createBundleProductCreateBundleProduct", "hook"); // stepKey: deleteDynamicBundleProduct
		$I->deleteEntity("simpleProduct1CreateBundleProduct", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2CreateBundleProduct", "hook"); // stepKey: deleteSimpleProduct2
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
	 * @Features({"Bundle"})
	 * @Stories({"View bundle products"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckBundleProductOptionTierPricesTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProductCreateBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToBundleProductPage
		$I->click("#bundle-slide"); // stepKey: clickCustomize
		$I->waitForPageLoad(30); // stepKey: clickCustomizeWaitForPageLoad
		$I->comment("\"Drop-down\" type option");
		$I->comment("Check Tier Prices for product 1");
		$I->selectOption("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: selectDropDownOptionProduct1
		$I->seeOptionIsSelected("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: checkDropDownOptionProduct1
		$DropDownTierPriceTextProduct1 = $I->grabTextFrom("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//div[@class='option-tier-prices']"); // stepKey: DropDownTierPriceTextProduct1
		$I->assertStringContainsString("Buy 5 for $5.00 each and save 50%", $DropDownTierPriceTextProduct1); // stepKey: assertDropDownTierPriceTextProduct1
		$I->comment("Check Tier Prices for product 2");
		$I->selectOption("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: selectDropDownOptionProduct2
		$I->seeOptionIsSelected("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: checkDropDownOptionProduct2
		$dropDownTierPriceTextProduct2 = $I->grabTextFrom("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//div[@class='option-tier-prices']"); // stepKey: dropDownTierPriceTextProduct2
		$I->assertStringContainsString("Buy 7 for $15.00 each and save 25%", $dropDownTierPriceTextProduct2); // stepKey: assertDropDownTierPriceTextProduct2
		$I->comment("\"Radio Buttons\" type option");
		$I->comment("Check Tier Prices for product 1");
		$radioButtonsOptionTierPriceTextProduct1 = $I->grabTextFrom("//label//span[contains(text(), 'Radio Buttons Option')]/../..//div[@class='control']//div[@class='field choice']//label[contains(.,'" . $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'name', 'test') . "')]"); // stepKey: radioButtonsOptionTierPriceTextProduct1
		$I->assertStringContainsString("Buy 5 for $5.00 each and save 50%", $radioButtonsOptionTierPriceTextProduct1); // stepKey: assertRadioButtonsOptionTierPriceTextProduct1
		$I->comment("Check Tier Prices for product 2");
		$radioButtonsOptionTierPriceTextProduct2 = $I->grabTextFrom("//label//span[contains(text(), 'Radio Buttons Option')]/../..//div[@class='control']//div[@class='field choice']//label[contains(.,'" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . "')]"); // stepKey: radioButtonsOptionTierPriceTextProduct2
		$I->assertStringContainsString("Buy 7 for $15.00 each and save 25%", $radioButtonsOptionTierPriceTextProduct2); // stepKey: assertRadioButtonsOptionTierPriceTextProduct2
		$I->comment("\"Checkbox\" type option");
		$I->comment("Check Tier Prices for product 1");
		$checkBoxOptionTierPriceTextProduct1 = $I->grabTextFrom("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice']//label[contains(.,'" . $I->retrieveEntityField('simpleProduct1CreateBundleProduct', 'name', 'test') . "')]"); // stepKey: checkBoxOptionTierPriceTextProduct1
		$I->assertStringContainsString("Buy 5 for $5.00 each and save 50%", $checkBoxOptionTierPriceTextProduct1); // stepKey: assertCheckBoxOptionTierPriceTextProduct1
		$I->comment("Check Tier Prices for product 2");
		$checkBoxOptionTierPriceTextProduct2 = $I->grabTextFrom("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice']//label[contains(.,'" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . "')]"); // stepKey: checkBoxOptionTierPriceTextProduct2
		$I->assertStringContainsString("Buy 7 for $15.00 each and save 25%", $checkBoxOptionTierPriceTextProduct2); // stepKey: assertCheckBoxOptionTierPriceTextProduct2
	}
}
